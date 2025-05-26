# 🚀 Render 部署完整指南

## 📋 部署前检查清单

- [x] 项目已推送到 GitHub: `https://github.com/xinglisds/cms-project.git`
- [x] Railway 数据库已配置
- [x] AWS S3 存储已配置
- [x] Gmail SMTP 已配置
- [x] render.yaml 配置文件已创建

## 🌐 第一步：在 Render 创建 Web Service

1. 访问 [Render](https://render.com/)
2. 使用 GitHub 账户登录
3. 点击 "New +" → "Web Service"
4. 连接你的 GitHub 仓库：`xinglisds/cms-project`
5. 配置基本设置：
   - **Name**: `cms-project`
   - **Region**: `Oregon (US West)`
   - **Branch**: `master`
   - **Runtime**: `Docker` (会自动检测到 render.yaml)

## 🔧 第二步：配置环境变量

在 Render 控制台的 Environment 标签中添加以下环境变量：

### 基础应用配置
```
APP_NAME=LiteCMS
APP_ENV=production
APP_KEY=base64:kpqsdOm1lpjmp1kFpqnJHP2k9wAsgyFqJZ/BQHas9ok=
APP_DEBUG=false
APP_URL=https://cms-project-xxxx.onrender.com
```
> 注意：APP_URL 需要在部署后更新为实际的 Render URL

### 数据库配置 (Railway)
```
DB_CONNECTION=mysql
DB_HOST=你的-railway-mysql-host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=你的-mysql-密码
```

### AWS S3 配置
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=你的-aws-access-key-id
AWS_SECRET_ACCESS_KEY=你的-aws-secret-access-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=你的-s3-bucket-name
AWS_URL=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Gmail SMTP 配置
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=你的-gmail@gmail.com
MAIL_PASSWORD=你的-16位-应用密码
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=你的-gmail@gmail.com
MAIL_FROM_NAME=LiteCMS
```

### Google Perspective API
```
PERSPECTIVE_API_KEY=你的-perspective-api-key
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
BCRYPT_ROUNDS=12
BROADCAST_CONNECTION=log
```

## 🚀 第三步：部署

1. 点击 "Create Web Service"
2. Render 会自动开始构建和部署
3. 等待部署完成（通常需要 5-10 分钟）

## 📝 第四步：部署后配置

### 1. 更新 APP_URL
部署完成后，获取实际的 Render URL（如：`https://cms-project-xxxx.onrender.com`），然后：
1. 在 Environment 中更新 `APP_URL` 变量
2. 点击 "Manual Deploy" 重新部署

### 2. 验证部署
访问你的网站 URL，检查：
- [ ] 首页可以正常访问
- [ ] 用户注册功能正常
- [ ] 用户登录功能正常
- [ ] 文章创建功能正常
- [ ] 图片上传功能正常（S3）
- [ ] 评论功能正常
- [ ] 邮件发送功能正常

## 🔍 故障排除

### 查看部署日志
1. 在 Render 控制台点击你的服务
2. 查看 "Logs" 标签
3. 检查构建和运行时错误

### 常见问题

#### 1. 数据库连接失败
```
SQLSTATE[HY000] [2002] Connection refused
```
**解决方案**：
- 检查 Railway 数据库连接信息
- 确认数据库服务正在运行
- 验证用户名和密码

#### 2. S3 文件上传失败
```
Error executing "PutObject" on "https://s3.amazonaws.com/..."
```
**解决方案**：
- 检查 AWS 凭证
- 验证 S3 存储桶权限
- 确认存储桶名称正确

#### 3. 邮件发送失败
```
Connection could not be established with host smtp.gmail.com
```
**解决方案**：
- 检查 Gmail 应用专用密码
- 确认两步验证已启用
- 验证邮箱地址正确

#### 4. 应用密钥错误
```
The payload is invalid.
```
**解决方案**：
- 确认 APP_KEY 格式正确（以 `base64:` 开头）
- 重新生成应用密钥

## 📊 监控和维护

### 1. 性能监控
- 在 Render 控制台查看 CPU 和内存使用情况
- 监控响应时间和错误率

### 2. 日志监控
- 定期检查应用日志
- 关注错误和警告信息

### 3. 数据库维护
- 在 Railway 控制台监控数据库性能
- 定期备份重要数据

### 4. 成本优化
- 监控 AWS S3 使用量
- 检查 Render 和 Railway 的使用费用

## 🔐 安全建议

1. **定期更新依赖**
   ```bash
   composer update
   npm update
   ```

2. **监控安全漏洞**
   ```bash
   composer audit
   npm audit
   ```

3. **备份策略**
   - 定期备份数据库
   - 备份重要的 S3 文件

4. **访问控制**
   - 定期轮换 API 密钥
   - 监控异常登录活动

## 📞 支持资源

- [Render 文档](https://render.com/docs)
- [Laravel 部署文档](https://laravel.com/docs/deployment)
- [Railway 文档](https://docs.railway.app/)
- [AWS S3 文档](https://docs.aws.amazon.com/s3/)

---

## 🎉 部署成功！

如果一切顺利，你的 LiteCMS 现在应该已经在生产环境中运行了！

**你的网站地址**: `https://cms-project-xxxx.onrender.com`

记得将实际的 URL 分享给用户，并开始享受你的内容管理系统吧！ 