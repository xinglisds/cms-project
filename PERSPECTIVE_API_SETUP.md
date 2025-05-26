# Google Perspective API 设置指南

## 概述

Task 21 实现了使用 Google Perspective API 进行评论内容审核的功能。该功能可以自动检测和阻止包含有害内容的评论，如侮辱、威胁、仇恨言论等。

## 功能特性

- ✅ 实时评论内容分析
- ✅ 多种有害内容检测（毒性、侮辱、威胁、仇恨言论等）
- ✅ 可配置的阈值设置
- ✅ 优雅的错误处理和超时处理
- ✅ 详细的日志记录
- ✅ 失败开放策略（API 不可用时允许评论）

## 设置步骤

### 1. 获取 Google Perspective API 密钥

1. 访问 [Google Cloud Console](https://console.cloud.google.com/)
2. 创建新项目或选择现有项目
3. 启用 Perspective Comment Analyzer API
4. 创建 API 密钥
5. 复制 API 密钥

### 2. 配置环境变量

在 `.env` 文件中添加：

```env
PERSPECTIVE_API_KEY=your_api_key_here
```

### 3. 测试配置

运行以下命令测试配置：

```bash
php artisan tinker
```

然后在 tinker 中执行：

```php
$service = new App\Services\PerspectiveApiService();
$result = $service->analyzeComment("This is a test comment");
var_dump($result);
```

## 使用方式

### 自动审核

评论审核已自动集成到评论提交流程中：

1. 用户提交评论
2. 系统自动调用 Perspective API 分析内容
3. 如果内容被标记为有害，显示错误消息
4. 如果内容安全，正常保存评论

### 阈值配置

在 `app/Services/PerspectiveApiService.php` 中可以调整各种内容类型的阈值：

```php
private function isCommentAllowed(array $scores): bool
{
    $thresholds = [
        'toxicity' => 0.7,        // 毒性
        'severe_toxicity' => 0.5, // 严重毒性
        'identity_attack' => 0.7, // 身份攻击
        'insult' => 0.7,          // 侮辱
        'profanity' => 0.8,       // 亵渎
        'threat' => 0.5,          // 威胁
    ];
    // ...
}
```

## 错误处理

系统包含完善的错误处理机制：

- **API 超时**: 允许评论并记录日志
- **API 错误**: 允许评论并记录日志
- **网络错误**: 允许评论并记录日志
- **配置错误**: 允许评论并记录警告

## 日志监控

所有 API 调用和错误都会记录到 Laravel 日志中：

```bash
tail -f storage/logs/laravel.log | grep Perspective
```

## 生产环境注意事项

1. **API 配额**: 注意 Google Perspective API 的使用配额限制
2. **性能**: API 调用会增加评论提交的延迟
3. **备用方案**: 系统设计为失败开放，确保 API 不可用时不影响用户体验
4. **监控**: 建议设置日志监控来跟踪 API 使用情况

## 自定义错误消息

可以在 `PerspectiveApiService::getRejectionMessage()` 方法中自定义不同类型有害内容的错误消息。

## 支持的语言

当前配置支持英文和中文内容分析：

```php
'languages' => ['en', 'zh']
```

可以根据需要添加其他语言代码。 