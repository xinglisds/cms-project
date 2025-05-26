<?php

echo "🔍 检查生产环境资源文件\n";
echo "========================\n\n";

// 检查 manifest.json
if (file_exists('public/build/manifest.json')) {
    echo "✅ manifest.json 存在\n";
    $manifest = json_decode(file_get_contents('public/build/manifest.json'), true);
    
    echo "\n📄 Manifest 内容:\n";
    foreach ($manifest as $key => $value) {
        echo "  $key -> {$value['file']}\n";
        
        // 检查实际文件是否存在
        $filePath = 'public/build/' . $value['file'];
        if (file_exists($filePath)) {
            $size = round(filesize($filePath) / 1024, 2);
            echo "    ✅ 文件存在 ({$size} KB)\n";
        } else {
            echo "    ❌ 文件不存在: $filePath\n";
        }
    }
} else {
    echo "❌ manifest.json 不存在\n";
}

echo "\n🎨 检查 CSS 文件:\n";
$cssFiles = glob('public/build/assets/*.css');
if (count($cssFiles) > 0) {
    foreach ($cssFiles as $file) {
        $size = round(filesize($file) / 1024, 2);
        echo "✅ " . basename($file) . " ({$size} KB)\n";
        
        // 检查是否包含 Tailwind 类
        $content = file_get_contents($file);
        if (strpos($content, 'tailwind') !== false || strpos($content, '.bg-') !== false) {
            echo "  ✅ 包含 Tailwind CSS\n";
        } else {
            echo "  ⚠️  可能缺少 Tailwind CSS\n";
        }
    }
} else {
    echo "❌ 没有找到 CSS 文件\n";
}

echo "\n📜 检查 JS 文件:\n";
$jsFiles = glob('public/build/assets/*.js');
if (count($jsFiles) > 0) {
    foreach ($jsFiles as $file) {
        $size = round(filesize($file) / 1024, 2);
        echo "✅ " . basename($file) . " ({$size} KB)\n";
    }
} else {
    echo "❌ 没有找到 JS 文件\n";
}

echo "\n🔧 Vite 助手函数测试:\n";
try {
    // 模拟 Laravel 环境
    if (function_exists('app')) {
        echo "✅ Laravel 环境可用\n";
    } else {
        echo "⚠️  非 Laravel 环境，无法测试 Vite 助手\n";
    }
} catch (Exception $e) {
    echo "❌ 错误: " . $e->getMessage() . "\n";
}

echo "\n💡 建议:\n";
echo "1. 确保在生产环境中运行了 'npm run build'\n";
echo "2. 检查 APP_URL 环境变量是否正确设置\n";
echo "3. 确保 storage:link 已执行\n";
echo "4. 检查 Tailwind 配置的 content 路径\n";
echo "5. 验证 @vite() 指令在模板中正确使用\n"; 