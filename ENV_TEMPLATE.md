# 🌐 生产环境变量配置模板

## Render 环境变量设置

在 Render 控制台中设置以下环境变量：

### 基础应用配置
```
APP_NAME=LiteCMS
APP_ENV=production
APP_KEY=base64:your-generated-key-here
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
```

### 数据库配置 (Railway MySQL)
```
DB_CONNECTION=mysql
DB_HOST=your-railway-mysql-host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-mysql-password
```

### 数据库配置 (Railway PostgreSQL) - 可选
```
DB_CONNECTION=pgsql
DB_HOST=your-railway-postgres-host
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your-postgres-password
```

### 文件存储配置 (AWS S3)
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-aws-access-key-id
AWS_SECRET_ACCESS_KEY=your-aws-secret-access-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-s3-bucket-name
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

#### AWS S3 配置说明：
- `FILESYSTEM_DISK=s3`: 设置默认文件系统为 S3
- `AWS_ACCESS_KEY_ID`: IAM 用户的访问密钥 ID
- `AWS_SECRET_ACCESS_KEY`: IAM 用户的秘密访问密钥
- `AWS_DEFAULT_REGION`: S3 存储桶所在区域 (如: us-east-1, ap-southeast-1)
- `AWS_BUCKET`: S3 存储桶名称 (必须全球唯一)
- `AWS_URL`: 自定义域名 (可选，留空使用默认)
- `AWS_ENDPOINT`: 自定义端点 (可选，留空使用默认)
- `AWS_USE_PATH_STYLE_ENDPOINT`: 路径样式端点 (通常为 false)

### 邮件服务配置 (Gmail SMTP)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-16-digit-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME=LiteCMS
```

### Google Perspective API
```
PERSPECTIVE_API_KEY=your-perspective-api-key
```

### 会话和缓存配置
```
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 日志配置
```
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 其他配置
```
BCRYPT_ROUNDS=12
BROADCAST_CONNECTION=log
```

## 🔑 如何生成 APP_KEY

在本地运行以下命令生成应用密钥：
```bash
php artisan key:generate --show
```

然后将输出的密钥设置为 `APP_KEY` 环境变量。

## 🗄️ Railway 数据库设置步骤

1. 访问 [Railway](https://railway.app/)
2. 使用 GitHub 登录
3. 创建新项目
4. 添加 MySQL 或 PostgreSQL 数据库
5. 在 Variables 标签中获取连接信息
6. 复制相应的数据库配置到环境变量中

## ☁️ AWS S3 设置步骤

### 1. 创建 S3 存储桶
1. 登录 [AWS 控制台](https://aws.amazon.com/console/)
2. 搜索并进入 S3 服务
3. 点击 "Create bucket"
4. 设置存储桶名称 (如: `litecms-files-2024`)
5. 选择区域 (推荐: us-east-1)
6. 取消勾选 "Block all public access"
7. 创建存储桶

### 2. 配置存储桶策略
在存储桶的 Permissions > Bucket policy 中添加：
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

### 3. 创建 IAM 用户
1. 搜索并进入 IAM 服务
2. 点击 Users > Create user
3. 用户名: `litecms-s3-user`
4. 勾选 "Programmatic access"
5. 附加策略: `AmazonS3FullAccess`
6. 创建用户并保存访问密钥

## 📧 Gmail SMTP 设置步骤

1. 启用 Gmail 两步验证
2. 生成应用专用密码：
   - 访问 [Google 账户安全设置](https://myaccount.google.com/security)
   - 点击 "应用专用密码"
   - 选择 "邮件" 和 "其他"
   - 输入名称: `LiteCMS`
   - 复制生成的 16 位密码

## 🧪 测试配置

### 测试数据库连接
```bash
php test_database.php
```

### 测试 S3 连接
```bash
php test_s3.php
```

### 测试邮件发送
```bash
php test_email.php
```

## ⚠️ 安全提醒

- 永远不要将敏感信息提交到代码仓库
- 定期轮换 AWS 访问密钥
- 使用强密码和复杂的 API 密钥
- 监控 AWS 使用量和费用 