# ✅ 部署检查清单

## 📋 部署前准备

### 1. 服务账户设置
- [ ] **Railway**: 创建数据库并获取连接信息
- [ ] **AWS S3**: 创建存储桶和IAM用户，获取访问密钥
- [ ] **MailerSend**: 注册账户并获取API密钥
- [ ] **Google Perspective API**: 获取API密钥
- [ ] **GitHub**: 确保代码已推送到仓库

### 2. 本地测试
- [ ] 运行 `composer install` 确保依赖完整
- [ ] 运行 `npm install && npm run build` 确保前端资源构建成功
- [ ] 测试所有功能正常工作
- [ ] 确认评论审核功能正常

## 🚀 Render 部署步骤

### 1. 创建新服务
1. 登录 [Render](https://render.com/)
2. 点击 "New +" → "Web Service"
3. 连接你的 GitHub 仓库
4. 选择 `cms-project` 仓库

### 2. 配置构建设置
- **Name**: `cms-project` (或你喜欢的名称)
- **Environment**: `PHP`
- **Build Command**: 
  ```bash
  composer install --no-dev --optimize-autoloader && npm install && npm run build
  ```
- **Start Command**: 
  ```bash
  php artisan migrate --force && php artisan storage:link && php -S 0.0.0.0:$PORT -t public
  ```

### 3. 设置环境变量
复制 `ENV_TEMPLATE.md` 中的所有环境变量到 Render：

#### 必需的环境变量
- [ ] `APP_KEY`: `base64:6tpe+gZt9AqLBC3rZrocc9TISSEtNlHIorvmqBU6+a0=`
- [ ] `APP_URL`: `https://your-app-name.onrender.com`
- [ ] 所有数据库配置 (Railway)
- [ ] 所有 AWS S3 配置
- [ ] 所有 MailerSend 配置
- [ ] Perspective API 密钥

### 4. 部署
- [ ] 点击 "Create Web Service"
- [ ] 等待构建完成（约5-10分钟）
- [ ] 检查部署日志确认无错误

## 🧪 部署后测试

### 1. 基础功能测试
- [ ] 网站可以正常访问
- [ ] 首页加载正常
- [ ] 文章列表显示正常

### 2. 用户功能测试
- [ ] 用户注册功能正常
- [ ] 用户登录功能正常
- [ ] 密码重置功能正常（如果配置了邮件）

### 3. 管理员功能测试
- [ ] 管理员登录正常
- [ ] 文章创建功能正常
- [ ] 图片上传到S3正常
- [ ] 文章编辑和删除正常

### 4. 评论功能测试
- [ ] 用户可以提交评论
- [ ] 有害评论被正确拦截
- [ ] 安全评论正常显示

### 5. 其他功能测试
- [ ] Newsletter订阅功能正常
- [ ] 管理后台各功能正常
- [ ] RSS导入功能正常（如果需要）

## 🚨 常见问题排查

### 部署失败
1. 检查 Render 构建日志
2. 确认所有依赖包已正确安装
3. 检查 PHP 版本兼容性

### 数据库连接失败
1. 确认 Railway 连接信息正确
2. 检查 Railway 数据库服务状态
3. 验证数据库用户权限

### 文件上传失败
1. 检查 AWS S3 权限配置
2. 确认存储桶 CORS 设置
3. 验证 AWS 访问密钥

### 邮件发送失败
1. 验证 MailerSend API 密钥
2. 检查发送域名验证状态
3. 确认发件人地址配置

## 📞 获取帮助

如果遇到问题：
1. 查看 Render 应用日志
2. 检查 Railway 数据库状态
3. 参考官方文档
4. 联系技术支持

## 🎉 部署完成

恭喜！你的 LiteCMS 项目已成功部署到生产环境！

记住定期：
- 备份数据库
- 更新依赖包
- 监控应用性能
- 检查安全更新 