<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some active sidebar ads
        Ad::factory()->active()->sidebar()->create([
            'title' => '专业网站建设服务',
            'target_url' => 'https://example.com/web-design',
        ]);

        Ad::factory()->active()->sidebar()->create([
            'title' => '云服务器托管',
            'target_url' => 'https://example.com/hosting',
        ]);

        Ad::factory()->active()->sidebar()->create([
            'title' => 'SEO优化咨询',
            'target_url' => 'https://example.com/seo',
        ]);

        // Create some other position ads
        Ad::factory()->active()->create([
            'title' => '头部横幅广告',
            'position' => 'header',
            'target_url' => 'https://example.com/header-ad',
        ]);

        Ad::factory()->active()->create([
            'title' => '内容区域推广',
            'position' => 'content',
            'target_url' => 'https://example.com/content-ad',
        ]);

        // Create a few random ads
        Ad::factory(5)->active()->create();
    }
}
