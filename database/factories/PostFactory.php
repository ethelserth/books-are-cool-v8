<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'user_id'            => User::factory(),
            'title'              => $this->faker->sentence(),
            'author'             => $this->faker->sentence(1),
            'slug'               => $this->faker->sentence(3),
            'content'            => $this->faker->paragraph(10),
            'image'              => $this->faker->imageUrl(),
            'meta_title'         => $this->faker->sentence(),
            'meta_keywords'      => $this->faker->sentence(),
            'meta_description'   => $this->faker->sentence(),
            'published_at'       => $this->faker->dateTimeBetween('-1 Week','+1 Week'),
            'featured'           => $this->faker->boolean(10),
            'enabled'            => $this->faker->boolean(95),
        ];
    }
}
