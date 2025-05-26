# 🚂 Railway 数据库设置指南

Railway 是一个现代化的云平台，提供简单易用的数据库服务。本指南将帮你为 LiteCMS 项目设置 Railway 数据库。

## 🌟 为什么选择 Railway？

- ✅ **简单易用**: 几分钟内即可设置完成
- ✅ **自动备份**: 内置数据备份功能
- ✅ **高性能**: 基于 SSD 的高速存储
- ✅ **免费额度**: 提供慷慨的免费使用额度
- ✅ **多数据库支持**: 支持 MySQL、PostgreSQL、Redis 等

## 📋 设置步骤

### 1. 创建 Railway 账户

1. 访问 [Railway](https://railway.app/)
2. 点击 "Login" 
3. 选择 "Login with GitHub"
4. 授权 Railway 访问你的 GitHub 账户

### 2. 创建新项目

1. 登录后，点击 "New Project"
2. 选择 "Empty Project"
3. 为项目命名（例如：`cms-project`）

### 3. 添加数据库服务

#### 选项 A: MySQL 数据库
1. 在项目面板中，点击 "New Service"
2. 选择 "Database"
3. 选择 "Add MySQL"
4. 等待数据库创建完成（约1-2分钟）

#### 选项 B: PostgreSQL 数据库
1. 在项目面板中，点击 "New Service"
2. 选择 "Database"
3. 选择 "Add PostgreSQL"
4. 等待数据库创建完成（约1-2分钟）

### 4. 获取连接信息

1. 点击你创建的数据库服务
2. 切换到 "Variables" 标签
3. 你将看到以下环境变量：

#### MySQL 连接信息
```
MYSQL_HOST=containers-us-west-xxx.railway.app
MYSQL_PORT=6543
MYSQL_DATABASE=railway
MYSQL_USER=root
MYSQL_PASSWORD=xxxxxxxxxx
MYSQL_URL=mysql://root:xxxxxxxxxx@containers-us-west-xxx.railway.app:6543/railway
```

#### PostgreSQL 连接信息
```
PGHOST=containers-us-west-xxx.railway.app
PGPORT=5432
PGDATABASE=railway
PGUSER=postgres
PGPASSWORD=xxxxxxxxxx
DATABASE_URL=postgresql://postgres:xxxxxxxxxx@containers-us-west-xxx.railway.app:5432/railway
```

### 5. 配置 Laravel 环境变量

#### 使用 MySQL
在你的 `.env` 文件中添加：
```env
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=6543
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your-mysql-password
```

#### 使用 PostgreSQL
在你的 `.env` 文件中添加：
```env
DB_CONNECTION=pgsql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your-postgres-password
```

### 6. 测试连接

运行数据库测试脚本：
```bash
php test_database.php
```

如果看到 "✅ 数据库连接成功!" 说明配置正确。

### 7. 运行迁移

```bash
php artisan migrate
```

## 🔧 高级配置

### 连接池设置
对于生产环境，建议在 `config/database.php` 中配置连接池：

```php
'mysql' => [
    // ... 其他配置
    'options' => [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ],
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 10,
        'connect_timeout' => 10.0,
        'wait_timeout' => 3.0,
        'heartbeat' => -1,
        'max_idle_time' => 60.0,
    ],
],
```

### SSL 连接（推荐）
Railway 默认支持 SSL 连接，无需额外配置。

## 📊 监控和管理

### 1. 数据库监控
在 Railway 控制台中，你可以：
- 查看数据库性能指标
- 监控连接数
- 查看查询日志

### 2. 备份管理
Railway 自动为你的数据库创建备份：
- 每日自动备份
- 保留 7 天的备份历史
- 可手动创建备份快照

### 3. 扩容
根据需要，你可以：
- 升级数据库实例大小
- 增加存储空间
- 调整连接数限制

## 💰 费用说明

### 免费额度
- **执行时间**: 每月 500 小时
- **网络流量**: 每月 100GB
- **存储空间**: 1GB

### 付费计划
- **Hobby**: $5/月，包含更多资源
- **Pro**: $20/月，适合生产环境

## 🚨 常见问题

### Q: 连接超时怎么办？
A: 检查网络连接，确认 Railway 服务状态正常。

### Q: 如何重置数据库密码？
A: 在 Railway 控制台中删除并重新创建数据库服务。

### Q: 可以连接外部工具吗？
A: 是的，使用提供的连接信息可以连接 MySQL Workbench、pgAdmin 等工具。

### Q: 数据库性能如何优化？
A: 
1. 使用适当的索引
2. 优化查询语句
3. 考虑升级到更高配置的实例

## 🔗 有用链接

- [Railway 官方文档](https://docs.railway.app/)
- [Railway 数据库指南](https://docs.railway.app/databases/mysql)
- [Railway 社区论坛](https://help.railway.app/)

## 🎉 完成！

恭喜！你已经成功设置了 Railway 数据库。现在可以继续配置其他服务（AWS S3、MailerSend）并部署到 Render。 