# 🌐 生产环境变量配置模板

## Render 环境变量设置

在 Render 控制台中设置以下环境变量：

### 基础应用配置
```
APP_NAME=CMS Project
APP_ENV=production
APP_KEY=base64:your-generated-key-here
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
```

### 数据库配置 (PlanetScale)
```
DB_CONNECTION=mysql
DB_HOST=your-planetscale-host.psdb.cloud
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
DB_SSLMODE=require
```

### 文件存储配置 (AWS S3)
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-aws-access-key
AWS_SECRET_ACCESS_KEY=your-aws-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-s3-bucket-name
```

### 邮件服务配置 (MailerSend)
```
MAIL_MAILER=mailersend
MAILERSEND_API_KEY=your-mailersend-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=CMS Project
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