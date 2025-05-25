<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('target_url');
            $table->enum('position', ['sidebar', 'header', 'footer', 'content'])->default('sidebar');
            $table->dateTime('active_from');
            $table->dateTime('active_to');
            $table->timestamps();

            // Add indexes for performance
            $table->index(['position', 'active_from', 'active_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
