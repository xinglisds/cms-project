<?php

require_once 'vendor/autoload.php';

// 模拟Laravel环境
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// 启动Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// 加载配置
$app->useConfigPath(__DIR__ . '/config');

// 加载环境变量
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 设置配置
$app['config']->set('filesystems.default', $_ENV['FILESYSTEM_DISK'] ?? 'local');
$app['config']->set('filesystems.disks.s3', [
    'driver' => 's3',
    'key' => $_ENV['AWS_ACCESS_KEY_ID'] ?? '',
    'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'] ?? '',
    'region' => $_ENV['AWS_DEFAULT_REGION'] ?? 'us-east-1',
    'bucket' => $_ENV['AWS_BUCKET'] ?? '',
    'url' => $_ENV['AWS_URL'] ?? '',
    'endpoint' => $_ENV['AWS_ENDPOINT'] ?? '',
    'use_path_style_endpoint' => false,
    'throw' => false,
]);

echo "=== Laravel Storage::url() 测试 ===\n\n";

try {
    // 测试Storage::url()方法
    $testPath = 'cover_images/jFVgF88x5XHsKflLEkbL618ECI30lqIz7Equp6qu.png';
    
    echo "测试文件路径: {$testPath}\n";
    echo "当前文件系统: " . config('filesystems.default') . "\n";
    echo "AWS_URL设置: " . ($_ENV['AWS_URL'] ?? '未设置') . "\n\n";
    
    // 使用Storage facade
    $url = \Illuminate\Support\Facades\Storage::url($testPath);
    echo "Storage::url() 输出: {$url}\n\n";
    
    // 直接使用S3客户端生成URL
    $s3Client = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => $_ENV['AWS_DEFAULT_REGION'] ?? 'us-east-1',
        'credentials' => [
            'key' => $_ENV['AWS_ACCESS_KEY_ID'] ?? '',
            'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'] ?? '',
        ],
    ]);
    
    $directUrl = $s3Client->getObjectUrl($_ENV['AWS_BUCKET'], $testPath);
    echo "S3Client直接生成URL: {$directUrl}\n\n";
    
    // 测试URL访问性
    echo "测试URL访问性:\n";
    $headers1 = @get_headers($url);
    $headers2 = @get_headers($directUrl);
    
    echo "Storage::url() - " . ($headers1 && strpos($headers1[0], '200') !== false ? '✓ 可访问' : '✗ 无法访问') . "\n";
    echo "直接URL - " . ($headers2 && strpos($headers2[0], '200') !== false ? '✓ 可访问' : '✗ 无法访问') . "\n";
    
} catch (Exception $e) {
    echo "测试失败: " . $e->getMessage() . "\n";
}

echo "\n=== 解决方案 ===\n";
echo "如果Storage::url()生成的URL无法访问，需要:\n";
echo "1. 在.env中设置AWS_URL为你的S3 bucket的公开URL\n";
echo "2. AWS_URL格式: https://your-bucket-name.s3.your-region.amazonaws.com\n";
echo "3. 或者修改代码直接使用S3Client生成URL\n";
echo "\n"; 