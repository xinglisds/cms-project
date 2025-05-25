<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing sidebar and content ads to header
        DB::table('ads')
            ->whereIn('position', ['sidebar', 'content'])
            ->update(['position' => 'header']);

        // Then modify the enum to only include header and footer
        DB::statement("ALTER TABLE ads MODIFY COLUMN position ENUM('header', 'footer') DEFAULT 'header'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original enum values
        DB::statement("ALTER TABLE ads MODIFY COLUMN position ENUM('sidebar', 'header', 'footer', 'content') DEFAULT 'sidebar'");
    }
};
