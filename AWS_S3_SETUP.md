# AWS S3 文件存储设置指南

本指南将帮助您为 LiteCMS 项目配置 AWS S3 文件存储服务。

## 📋 前提条件

- AWS 账户（如果没有，请先注册）
- 已完成邮件服务配置
- Laravel 项目已安装必要的包

## 🔧 第一步：安装必要的 Laravel 包

首先确保已安装 AWS S3 支持包：

```bash
composer require league/flysystem-aws-s3-v3
```

## ☁️ 第二步：创建 AWS S3 存储桶

### 1. 登录 AWS 控制台
1. 访问 [AWS 管理控制台](https://aws.amazon.com/console/)
2. 使用您的 AWS 账户登录

### 2. 创建 S3 存储桶
1. 在服务搜索框中输入 "S3" 并选择
2. 点击 **"Create bucket"** 按钮
3. 配置存储桶：
   - **Bucket name**: `litecms-files-[您的唯一标识]` (例如: `litecms-files-2024`)
   - **Region**: 选择离您用户最近的区域 (推荐: `us-east-1` 或 `ap-southeast-1`)
   - **Object Ownership**: 选择 "ACLs enabled"
   - **Block Public Access**: 取消勾选 "Block all public access" (用于公开访问图片)
   - 确认风险提示
4. 其他设置保持默认，点击 **"Create bucket"**

### 3. 配置存储桶权限
1. 进入刚创建的存储桶
2. 点击 **"Permissions"** 标签
3. 在 **"Bucket policy"** 部分点击 **"Edit"**
4. 添加以下策略（替换 `YOUR-BUCKET-NAME` 为您的存储桶名称）：

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "PublicReadGetObject",
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::YOUR-BUCKET-NAME/*"
        }
    ]
}
```

5. 点击 **"Save changes"**

## 👤 第三步：创建 IAM 用户

### 1. 访问 IAM 服务
1. 在 AWS 控制台搜索 "IAM" 并选择
2. 在左侧菜单点击 **"Users"**
3. 点击 **"Create user"**

### 2. 配置用户
1. **User name**: `litecms-s3-user`
2. **Access type**: 勾选 "Programmatic access"
3. 点击 **"Next"**

### 3. 设置权限
1. 选择 **"Attach existing policies directly"**
2. 搜索并选择 **"AmazonS3FullAccess"**
3. 点击 **"Next"** (跳过标签)
4. 点击 **"Create user"**

### 4. 保存访问密钥
⚠️ **重要**: 复制并安全保存以下信息（只会显示一次）：
- **Access Key ID**: `AKIA...`
- **Secret Access Key**: `...`

## 🔧 第四步：配置 Laravel 环境变量

在您的 `.env` 文件中添加以下配置：

```env
# AWS S3 基本配置 (必需)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key-id
AWS_SECRET_ACCESS_KEY=your-secret-access-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name

# AWS S3 高级配置 (可选，通常留空)
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### 配置说明：

#### 必需配置：
- `FILESYSTEM_DISK=s3`: 设置默认文件系统为 S3
- `AWS_ACCESS_KEY_ID`: 从 IAM 用户获取的访问密钥 ID
- `AWS_SECRET_ACCESS_KEY`: 从 IAM 用户获取的秘密访问密钥
- `AWS_DEFAULT_REGION`: 您选择的 S3 区域 (如: us-east-1, ap-southeast-1)
- `AWS_BUCKET`: 您创建的存储桶名称

#### 可选配置（通常留空）：
- `AWS_URL`: 自定义域名或 CDN 地址
  - **留空**: 使用默认 S3 URL (推荐)
  - **CloudFront**: `https://d1234567890.cloudfront.net`
  - **自定义域名**: `https://files.yourdomain.com`

- `AWS_ENDPOINT`: 自定义 S3 端点
  - **留空**: 使用默认 AWS S3 端点 (推荐)
  - **S3 兼容服务**: `https://minio.yourdomain.com`
  - **本地开发**: `http://localhost:9000`

- `AWS_USE_PATH_STYLE_ENDPOINT`: 路径样式端点
  - **false**: 使用虚拟主机样式 (推荐)
  - **true**: 使用路径样式 (某些 S3 兼容服务需要)

### 🎯 推荐的初始配置

对于大多数用户，只需要配置以下必需项：

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=AKIA...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=litecms-files-2024
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## 📝 第五步：更新 Laravel 配置

确保 `config/filesystems.php` 中的 S3 配置正确：

```php
'disks' => [
    // ... 其他配置

    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],

'default' => env('FILESYSTEM_DISK', 'local'),
```

## 🧪 第六步：测试 S3 连接

创建测试脚本 `test_s3.php`：

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Application;

// 创建 Laravel 应用实例
$app = new Application(__DIR__);

// 加载配置
$app->singleton('config', function () {
    return new \Illuminate\Config\Repository([
        'filesystems' => [
            'default' => 's3',
            'disks' => [
                's3' => [
                    'driver' => 's3',
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    'region' => env('AWS_DEFAULT_REGION'),
                    'bucket' => env('AWS_BUCKET'),
                    'url' => env('AWS_URL'),
                    'endpoint' => env('AWS_ENDPOINT'),
                    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
                    'throw' => false,
                ],
            ],
        ],
    ]);
});

// 设置应用实例
\Illuminate\Container\Container::setInstance($app);

echo "=== AWS S3 连接测试 ===\n\n";

try {
    // 测试文件上传
    $testContent = "LiteCMS S3 测试文件 - " . date('Y-m-d H:i:s');
    $testPath = 'test/test-file.txt';
    
    Storage::disk('s3')->put($testPath, $testContent);
    echo "✅ 文件上传成功: {$testPath}\n";
    
    // 测试文件读取
    $content = Storage::disk('s3')->get($testPath);
    echo "✅ 文件读取成功: {$content}\n";
    
    // 测试文件 URL 生成
    $url = Storage::disk('s3')->url($testPath);
    echo "✅ 文件 URL: {$url}\n";
    
    // 测试文件删除
    Storage::disk('s3')->delete($testPath);
    echo "✅ 文件删除成功\n\n";
    
    echo "🎉 AWS S3 配置成功！\n";
    
} catch (Exception $e) {
    echo "❌ S3 连接失败: " . $e->getMessage() . "\n";
    echo "请检查您的 AWS 配置和网络连接。\n";
}
```

运行测试：
```bash
php test_s3.php
```

## 🔄 第七步：更新现有代码

确保 AdminController 使用 S3 存储：

```php
// 在 AdminController 中的文件上传部分
if ($request->hasFile('cover_image')) {
    // 使用动态文件系统配置
    $validated['cover_image'] = $request->file('cover_image')
        ->store('cover_images', config('filesystems.default'));
}
```

## 📊 第八步：监控和优化

### 1. 设置 CloudWatch 监控
- 在 AWS 控制台启用 S3 的 CloudWatch 指标
- 监控存储使用量和请求数量

### 2. 成本优化
- 考虑使用 S3 生命周期策略
- 对于不常访问的文件，可以转移到 S3 IA 或 Glacier

### 3. 安全最佳实践
- 定期轮换 IAM 用户的访问密钥
- 启用 S3 访问日志记录
- 考虑使用 S3 加密

## 🚨 常见问题解决

### 1. 权限被拒绝错误
- 检查 IAM 用户权限
- 确认存储桶策略配置正确
- 验证访问密钥是否正确

### 2. 文件上传失败
- 检查网络连接
- 确认存储桶名称正确
- 验证区域设置

### 3. 无法访问上传的文件
- 检查存储桶的公共访问设置
- 确认存储桶策略允许公共读取
- 验证文件路径正确

## 📞 下一步

S3 配置完成后，您可以继续：
1. **Render 部署设置** - 将应用部署到生产环境
2. **性能优化** - 配置 CDN 和缓存
3. **备份策略** - 设置自动备份

## 💡 提示

- 存储桶名称必须全球唯一
- 建议使用有意义的文件夹结构组织文件
- 定期检查 AWS 账单，避免意外费用
- 考虑使用环境变量管理不同环境的配置

---

**安全提醒**: 永远不要将 AWS 访问密钥提交到代码仓库中！ 