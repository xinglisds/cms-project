# 🔒 HTTPS Mixed Content 修复指南

## 🚨 问题描述
网站出现 Mixed Content 错误：页面使用 HTTPS 加载，但资源文件使用 HTTP 协议。

## 🔧 修复步骤

### 1. 更新 Render 环境变量

在 Render 控制台的 Environment 标签中，确保以下变量正确设置：

```env
APP_URL=https://cms-project-bphh.onrender.com
APP_ENV=production
FORCE_HTTPS=true
```

### 2. 添加额外的安全环境变量

```env
# 强制 HTTPS
FORCE_HTTPS=true
APP_FORCE_HTTPS=true

# 信任代理（Render 使用代理）
TRUSTED_PROXIES=*

# 安全头
SECURE_SSL_REDIRECT=true
```

### 3. 重新部署

更新环境变量后，点击 "Manual Deploy" 重新部署应用。

## 🔍 验证修复

部署完成后：
1. 访问网站
2. 按 F12 打开开发者工具
3. 查看 Console 标签
4. 刷新页面
5. 确认没有 Mixed Content 错误

## 📋 检查清单

- [ ] APP_URL 使用 https://
- [ ] 添加了 FORCE_HTTPS=true
- [ ] 重新部署完成
- [ ] 网站样式正常显示
- [ ] 没有 Mixed Content 错误

## 🚀 如果问题仍然存在

1. 清除浏览器缓存
2. 在 Render 控制台运行：
   ```bash
   php artisan config:clear
   php artisan view:clear
   php artisan route:clear
   ```
3. 检查 Render 日志是否有错误 