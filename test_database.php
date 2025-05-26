<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "🗄️ 测试数据库连接 (Railway)\n";
echo "=" . str_repeat("=", 40) . "\n\n";

try {
    // 显示当前数据库配置
    echo "📋 当前数据库配置:\n";
    echo "   连接类型: " . config('database.default') . "\n";
    echo "   主机: " . config('database.connections.' . config('database.default') . '.host') . "\n";
    echo "   端口: " . config('database.connections.' . config('database.default') . '.port') . "\n";
    echo "   数据库: " . config('database.connections.' . config('database.default') . '.database') . "\n";
    echo "   用户名: " . config('database.connections.' . config('database.default') . '.username') . "\n";
    echo "\n";

    // 测试连接
    echo "🔌 测试数据库连接...\n";
    DB::connection()->getPdo();
    echo "   ✅ 数据库连接成功!\n\n";

    // 获取数据库版本信息
    echo "📊 数据库信息:\n";
    $dbType = config('database.default');
    if ($dbType === 'mysql') {
        $version = DB::select('SELECT VERSION() as version')[0]->version;
        echo "   MySQL 版本: {$version}\n";
    } elseif ($dbType === 'pgsql') {
        $version = DB::select('SELECT version()')[0]->version;
        echo "   PostgreSQL 版本: {$version}\n";
    }
    echo "\n";

    // 测试查询
    echo "📊 测试基本查询...\n";
    if ($dbType === 'mysql') {
        $tables = DB::select('SHOW TABLES');
    } else {
        $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
    }
    echo "   ✅ 查询成功! 找到 " . count($tables) . " 个表\n\n";

    // 显示表列表
    if (count($tables) > 0) {
        echo "📋 数据库表列表:\n";
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "   - {$tableName}\n";
        }
        echo "\n";
    }

    // 测试用户表
    echo "👥 测试用户表...\n";
    $userCount = DB::table('users')->count();
    echo "   ✅ 用户表查询成功! 当前用户数: {$userCount}\n\n";

    // 测试文章表
    if (DB::getSchemaBuilder()->hasTable('articles')) {
        echo "📝 测试文章表...\n";
        $articleCount = DB::table('articles')->count();
        echo "   ✅ 文章表查询成功! 当前文章数: {$articleCount}\n\n";
    }

    echo "🎉 Railway 数据库测试完成! 所有测试通过.\n";
    echo "\n💡 提示: Railway 数据库已准备就绪，可以开始部署到生产环境。\n";

} catch (Exception $e) {
    echo "❌ 数据库连接失败!\n";
    echo "错误信息: " . $e->getMessage() . "\n\n";
    
    echo "🔧 请检查以下配置:\n";
    echo "1. .env 文件中的数据库配置是否正确\n";
    echo "2. Railway 数据库是否已创建并运行\n";
    echo "3. 网络连接是否正常\n";
    echo "4. 数据库用户权限是否正确\n";
    echo "5. 如果使用 PostgreSQL，确认连接类型为 'pgsql'\n";
    echo "6. 如果使用 MySQL，确认连接类型为 'mysql'\n\n";
    
    echo "🌐 Railway 数据库设置步骤:\n";
    echo "1. 访问 https://railway.app/\n";
    echo "2. 使用 GitHub 登录\n";
    echo "3. 创建新项目\n";
    echo "4. 添加 MySQL 或 PostgreSQL 数据库\n";
    echo "5. 在 Variables 标签中获取连接信息\n";
    echo "6. 更新 .env 文件中的数据库配置\n";
} 