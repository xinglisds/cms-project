<?php

require_once __DIR__ . '/vendor/autoload.php';

// 加载环境变量
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== AWS S3 连接测试 ===\n\n";

echo "1. 检查环境变量配置:\n";
echo "   AWS_ACCESS_KEY_ID: " . (env('AWS_ACCESS_KEY_ID') ? '已设置' : '❌ 未设置') . "\n";
echo "   AWS_SECRET_ACCESS_KEY: " . (env('AWS_SECRET_ACCESS_KEY') ? '已设置' : '❌ 未设置') . "\n";
echo "   AWS_DEFAULT_REGION: " . (env('AWS_DEFAULT_REGION') ?: '❌ 未设置') . "\n";
echo "   AWS_BUCKET: " . (env('AWS_BUCKET') ?: '❌ 未设置') . "\n";
echo "   FILESYSTEM_DISK: " . (env('FILESYSTEM_DISK') ?: 'local') . "\n\n";

if (!env('AWS_ACCESS_KEY_ID') || !env('AWS_SECRET_ACCESS_KEY') || !env('AWS_BUCKET')) {
    echo "❌ AWS 配置不完整，请检查 .env 文件中的 AWS 配置。\n\n";
    echo "需要配置的环境变量:\n";
    echo "AWS_ACCESS_KEY_ID=your-access-key-id\n";
    echo "AWS_SECRET_ACCESS_KEY=your-secret-access-key\n";
    echo "AWS_DEFAULT_REGION=us-east-1\n";
    echo "AWS_BUCKET=your-bucket-name\n";
    echo "FILESYSTEM_DISK=s3\n";
    exit(1);
}

try {
    // 创建 S3 客户端
    $s3Client = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => env('AWS_DEFAULT_REGION'),
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
    ]);

    echo "2. 测试 S3 连接...\n";
    
    // 测试存储桶访问
    $bucket = env('AWS_BUCKET');
    $result = $s3Client->headBucket(['Bucket' => $bucket]);
    echo "   ✅ 存储桶访问成功: {$bucket}\n";

    // 测试文件上传
    $testContent = "LiteCMS S3 测试文件 - " . date('Y-m-d H:i:s');
    $testKey = 'test/litecms-test-' . time() . '.txt';
    
    $s3Client->putObject([
        'Bucket' => $bucket,
        'Key' => $testKey,
        'Body' => $testContent,
        'ContentType' => 'text/plain',
    ]);
    echo "   ✅ 文件上传成功: {$testKey}\n";

    // 测试文件读取
    $result = $s3Client->getObject([
        'Bucket' => $bucket,
        'Key' => $testKey,
    ]);
    $retrievedContent = $result['Body']->getContents();
    echo "   ✅ 文件读取成功: " . substr($retrievedContent, 0, 50) . "...\n";

    // 生成文件 URL
    $url = $s3Client->getObjectUrl($bucket, $testKey);
    echo "   ✅ 文件 URL: {$url}\n";

    // 测试文件删除
    $s3Client->deleteObject([
        'Bucket' => $bucket,
        'Key' => $testKey,
    ]);
    echo "   ✅ 文件删除成功\n\n";

    echo "🎉 AWS S3 配置测试成功！\n\n";
    
    echo "=== 下一步 ===\n";
    echo "1. 确保 Laravel 的 config/filesystems.php 配置正确\n";
    echo "2. 在 AdminController 中使用 S3 存储文件\n";
    echo "3. 测试文章封面图片上传功能\n";
    echo "4. 准备进行 Render 部署\n";

} catch (Aws\Exception\AwsException $e) {
    echo "❌ AWS S3 错误: " . $e->getMessage() . "\n";
    echo "错误代码: " . $e->getAwsErrorCode() . "\n\n";
    
    echo "常见问题解决:\n";
    echo "1. 检查 AWS 访问密钥是否正确\n";
    echo "2. 确认 IAM 用户有 S3 访问权限\n";
    echo "3. 验证存储桶名称和区域设置\n";
    echo "4. 检查网络连接\n";
    
} catch (Exception $e) {
    echo "❌ 测试失败: " . $e->getMessage() . "\n";
    echo "错误文件: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 辅助函数
function env($key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?: $default;
} 