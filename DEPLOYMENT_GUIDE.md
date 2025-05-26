# 🚀 生产环境部署指南

本指南将帮你将 Laravel CMS 项目部署到生产环境，使用以下技术栈：
- **应用托管**: Render
- **数据库**: PlanetScale (MySQL)
- **邮件服务**: MailerSend
- **文件存储**: AWS S3

## 📋 部署前准备

### 1. 安装必要的 Laravel 包

```bash
# 安装 AWS S3 支持
composer require league/flysystem-aws-s3-v3

# 安装 MailerSend 支持
composer require mailersend/laravel
```

### 2. 更新 Laravel 配置

#### 配置 MailerSend (config/mail.php)
```php
'mailers' => [
    // ... 其他配置
    'mailersend' => [
        'transport' => 'mailersend',
    ],
],
```

#### 配置文件系统 (config/filesystems.php)
确保 S3 配置正确：
```php
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
```

## 🗄️ 1. PlanetScale 数据库设置

### 步骤 1: 创建 PlanetScale 数据库
1. 访问 [PlanetScale](https://planetscale.com/)
2. 创建新数据库
3. 获取连接信息

### 步骤 2: 配置数据库连接
```env
DB_CONNECTION=mysql
DB_HOST=your-planetscale-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
DB_SSLMODE=require
```

### 步骤 3: 运行迁移
```bash
php artisan migrate --force
```

## 📧 2. MailerSend 邮件服务设置

### 步骤 1: 获取 MailerSend API 密钥
1. 访问 [MailerSend](https://www.mailersend.com/)
2. 创建账户并获取 API 密钥
3. 验证发送域名

### 步骤 2: 配置环境变量
```env
MAIL_MAILER=mailersend
MAILERSEND_API_KEY=your-mailersend-api-key
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="CMS Project"
```

## ☁️ 3. AWS S3 文件存储设置

### 步骤 1: 创建 S3 存储桶
1. 登录 AWS 控制台
2. 创建新的 S3 存储桶
3. 配置公共访问权限（用于图片访问）

### 步骤 2: 创建 IAM 用户
1. 创建新的 IAM 用户
2. 附加 S3 访问权限
3. 获取 Access Key 和 Secret Key

### 步骤 3: 配置环境变量
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

### 步骤 4: 更新代码以使用 S3
确保文件上传使用正确的磁盘：
```php
// 在 AdminController 中
$validated['cover_image'] = $request->file('cover_image')->store('cover_images', 's3');
```

## 🌐 4. Render 部署设置

### 步骤 1: 准备项目
1. 确保代码推送到 GitHub
2. 创建 `render.yaml` 配置文件

### 步骤 2: 创建 render.yaml
```yaml
services:
  - type: web
    name: cms-project
    env: php
    buildCommand: |
      composer install --no-dev --optimize-autoloader
      npm install
      npm run build
      php artisan config:cache
      php artisan route:cache
      php artisan view:cache
    startCommand: |
      php artisan migrate --force
      php artisan storage:link
      php -S 0.0.0.0:$PORT -t public
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: LOG_LEVEL
        value: error
```

### 步骤 3: 在 Render 中配置环境变量
在 Render 控制台中设置以下环境变量：

#### 基础配置
```
APP_NAME=CMS Project
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
```

#### 数据库配置
```
DB_CONNECTION=mysql
DB_HOST=your-planetscale-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
DB_SSLMODE=require
```

#### AWS S3 配置
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

#### MailerSend 配置
```
MAIL_MAILER=mailersend
MAILERSEND_API_KEY=your-mailersend-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=CMS Project
```

#### Perspective API 配置
```
PERSPECTIVE_API_KEY=your-perspective-api-key
```

## 🔧 5. 部署前的代码优化

### 更新 AdminController 使用 S3
```php
// 在文件上传部分
if ($request->hasFile('cover_image')) {
    $validated['cover_image'] = $request->file('cover_image')->store('cover_images', config('filesystems.default'));
}
```

### 创建生产环境启动脚本
创建 `scripts/deploy.sh`:
```bash
#!/bin/bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## 📝 6. 部署检查清单

### 部署前检查
- [ ] 所有环境变量已配置
- [ ] 数据库连接测试成功
- [ ] S3 存储桶权限配置正确
- [ ] MailerSend API 密钥有效
- [ ] Perspective API 密钥有效

### 部署后检查
- [ ] 网站可以正常访问
- [ ] 用户注册/登录功能正常
- [ ] 文章创建和图片上传正常
- [ ] 评论功能和内容审核正常
- [ ] 邮件发送功能正常

## 🚨 常见问题解决

### 1. 文件上传失败
- 检查 S3 权限配置
- 确认 AWS 凭证正确
- 检查存储桶 CORS 配置

### 2. 数据库连接失败
- 确认 PlanetScale 连接字符串
- 检查 SSL 配置
- 验证用户权限

### 3. 邮件发送失败
- 验证 MailerSend API 密钥
- 检查发送域名验证状态
- 确认发件人地址配置

### 4. 评论审核不工作
- 检查 Perspective API 密钥
- 查看应用日志
- 确认 API 配额未超限

## 🔐 安全建议

1. **环境变量安全**
   - 不要在代码中硬编码敏感信息
   - 使用强密码和复杂的 API 密钥

2. **数据库安全**
   - 启用 SSL 连接
   - 定期备份数据

3. **文件存储安全**
   - 配置适当的 S3 权限
   - 启用版本控制

4. **应用安全**
   - 保持 Laravel 和依赖包更新
   - 启用 HTTPS
   - 配置适当的 CORS 策略

## 📞 支持

如果遇到部署问题，可以：
1. 检查 Render 部署日志
2. 查看 Laravel 应用日志
3. 参考各服务的官方文档 