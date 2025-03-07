<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'              => $this->faker->sentence(),
            'slug'               => $this->faker->sentence(3),
            'description'        => $this->faker->paragraph(3),
            'image'              => $this->faker->imageUrl(),
            'meta_title'         => $this->faker->sentence(),
            'meta_keywords'      => $this->faker->sentence(),
            'meta_description'   => $this->faker->sentence(),
        ];
    }
}
