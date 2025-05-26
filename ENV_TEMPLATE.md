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
AWS_ACCESS_KEY_ID=your-aws-access-key
AWS_SECRET_ACCESS_KEY=your-aws-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-s3-bucket-name
```

### 邮件服务配置 (Gmail SMTP)
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