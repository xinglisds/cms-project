<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'image' => 'ads/sample-ad.jpg', // We'll create a placeholder image
            'target_url' => $this->faker->url(),
            'position' => $this->faker->randomElement(['sidebar', 'header', 'footer', 'content']),
            'active_from' => Carbon::now()->subDays(rand(1, 30)),
            'active_to' => Carbon::now()->addDays(rand(30, 90)),
        ];
    }

    /**
     * Create an active ad
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'active_from' => Carbon::now()->subDays(rand(1, 5)),
            'active_to' => Carbon::now()->addDays(rand(30, 60)),
        ]);
    }

    /**
     * Create a sidebar ad
     */
    public function sidebar(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => 'sidebar',
        ]);
    }
}
