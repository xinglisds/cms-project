<?php

echo "🔍 LiteCMS 部署前检查\n";
echo "==================\n\n";

// 检查必要的文件
$requiredFiles = [
    'composer.json',
    'package.json',
    'render.yaml',
    'artisan',
    'public/index.php'
];

echo "📁 检查必要文件:\n";
foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file\n";
    } else {
        echo "❌ $file (缺失)\n";
    }
}

echo "\n📦 检查 Composer 依赖:\n";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer 依赖已安装\n";
} else {
    echo "❌ 需要运行: composer install\n";
}

echo "\n🎨 检查前端资源:\n";
if (file_exists('node_modules')) {
    echo "✅ Node.js 依赖已安装\n";
} else {
    echo "❌ 需要运行: npm install\n";
}

if (file_exists('public/build')) {
    echo "✅ 前端资源已构建\n";
} else {
    echo "❌ 需要运行: npm run build\n";
}

echo "\n🔧 检查 Laravel 配置:\n";
if (file_exists('bootstrap/cache/config.php')) {
    echo "✅ 配置已缓存\n";
} else {
    echo "⚠️  建议运行: php artisan config:cache\n";
}

if (file_exists('bootstrap/cache/routes-v7.php')) {
    echo "✅ 路由已缓存\n";
} else {
    echo "⚠️  建议运行: php artisan route:cache\n";
}

echo "\n🗄️ 检查数据库迁移:\n";
try {
    // 这里只是检查迁移文件是否存在
    $migrations = glob('database/migrations/*.php');
    if (count($migrations) > 0) {
        echo "✅ 找到 " . count($migrations) . " 个迁移文件\n";
    } else {
        echo "❌ 没有找到迁移文件\n";
    }
} catch (Exception $e) {
    echo "⚠️  无法检查迁移文件\n";
}

echo "\n📋 部署清单:\n";
echo "1. 确保所有代码已推送到 GitHub\n";
echo "2. 在 Render 中配置所有环境变量\n";
echo "3. 特别注意以下环境变量:\n";
echo "   - APP_KEY (已生成: base64:kpqsdOm1lpjmp1kFpqnJHP2k9wAsgyFqJZ/BQHas9ok=)\n";
echo "   - DB_* (Railway 数据库配置)\n";
echo "   - AWS_* (S3 存储配置)\n";
echo "   - MAIL_* (Gmail SMTP 配置)\n";
echo "   - PERSPECTIVE_API_KEY (内容审核)\n";

echo "\n🚀 准备部署到 Render!\n";
echo "GitHub 仓库: https://github.com/xinglisds/cms-project.git\n";
echo "参考文档: RENDER_DEPLOYMENT.md\n"; 