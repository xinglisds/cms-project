# 📧 Gmail SMTP 配置指南

本指南将帮你配置 Gmail SMTP 作为 LiteCMS 项目的邮件发送服务。

## 🌟 为什么选择 Gmail SMTP？

- ✅ **免费**: 每天可发送 500 封邮件
- ✅ **可靠**: Google 的邮件基础设施
- ✅ **简单**: 配置相对简单
- ✅ **无需信用卡**: 不需要付费账户

## 📋 配置步骤

### 1. 准备 Gmail 账户

#### 步骤 1.1: 启用两步验证
1. 登录你的 Gmail 账户
2. 访问 [Google 账户安全设置](https://myaccount.google.com/security)
3. 在"登录 Google"部分，点击"两步验证"
4. 按照提示启用两步验证

#### 步骤 1.2: 生成应用专用密码
1. 在 Google 账户安全设置中，找到"应用专用密码"
2. 点击"应用专用密码"
3. 选择"邮件"和"其他（自定义名称）"
4. 输入名称：`LiteCMS`
5. 点击"生成"
6. **重要**: 复制生成的 16 位密码，这将是你的 `MAIL_PASSWORD`

### 2. 配置 Laravel 环境变量

在你的 `.env` 文件中添加以下配置：

```env
# Gmail SMTP 配置
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME="CMS Project"
```

### 3. 生产环境配置

#### Render 环境变量设置
在 Render 控制台中设置以下环境变量：

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME=CMS Project
```

### 4. 测试邮件发送

#### 创建测试脚本
创建 `test_email.php` 来测试邮件发送：

```php
<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('这是一封测试邮件，来自 LiteCMS 项目！', function ($message) {
        $message->to('your-email@gmail.com')
                ->subject('LiteCMS 邮件测试');
    });
    
    echo "✅ 邮件发送成功！\n";
} catch (Exception $e) {
    echo "❌ 邮件发送失败: " . $e->getMessage() . "\n";
}
```

#### 运行测试
```bash
php test_email.php
```

### 5. 常见问题解决

#### 问题 1: "Less secure app access" 错误
**解决方案**: 确保使用应用专用密码，而不是 Gmail 账户密码。

#### 问题 2: "Authentication failed" 错误
**解决方案**: 
1. 检查用户名是否正确（完整的 Gmail 地址）
2. 确认应用专用密码正确
3. 确保两步验证已启用

#### 问题 3: "Connection timeout" 错误
**解决方案**:
1. 检查网络连接
2. 确认端口 587 未被防火墙阻止
3. 尝试使用端口 465 和 SSL 加密

#### 问题 4: 邮件进入垃圾箱
**解决方案**:
1. 设置合适的发件人名称
2. 避免垃圾邮件关键词
3. 考虑设置 SPF 记录（如果有自定义域名）

### 6. 高级配置

#### 使用自定义域名
如果你有自定义域名，可以：
1. 设置 Gmail 别名
2. 配置 SPF 记录
3. 设置 DKIM 签名

#### 邮件模板
Laravel 支持邮件模板，你可以创建美观的 HTML 邮件：

```php
// 创建邮件类
php artisan make:mail WelcomeEmail
```

### 7. 发送限制

#### Gmail SMTP 限制
- **每天**: 500 封邮件
- **每分钟**: 约 20-30 封邮件
- **收件人**: 每封邮件最多 100 个收件人

#### 超出限制的解决方案
如果需要发送更多邮件，考虑：
1. 使用 Google Workspace（付费）
2. 切换到专业邮件服务（如 SendGrid、Mailgun）
3. 使用多个 Gmail 账户轮换

## 🔐 安全建议

1. **应用专用密码安全**
   - 不要在代码中硬编码密码
   - 定期更换应用专用密码
   - 只在必要的应用中使用

2. **邮件内容安全**
   - 避免发送敏感信息
   - 使用 HTTPS 链接
   - 验证收件人地址

3. **账户安全**
   - 保持两步验证启用
   - 定期检查账户活动
   - 使用强密码

## 🎉 完成！

配置完成后，你的 LiteCMS 项目就可以通过 Gmail SMTP 发送邮件了！

### 可用功能：
- 用户注册确认邮件
- 密码重置邮件
- Newsletter 订阅确认
- 管理员通知邮件 