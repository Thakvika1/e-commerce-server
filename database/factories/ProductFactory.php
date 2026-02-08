<?php

namespace Database\Factories;

use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        
        
        // $filename = fake()->uuid() . '.jpg';
        // fake()->image(
        //     storage_path('app/public/products/' . $filename),
        //     640,
        //     640,
        //     null,
        //     false
        // );

        return [
            'name' => fake()->words(3, true), // e.g. "Wireless Headphones Pro"
            'description' => fake()->sentence(12),
            'price' => fake()->randomFloat(2, 5, 500), // $5 - $500
            'stock' => fake()->numberBetween(0, 100),
            'category_id' => Category::inRandomOrder()->first()->id,
            // 'image' => 'products/' . $filename,
            'image' => "https://picsum.photos/640/640?random=" . fake()->numberBetween(1, 1000),
        ];
    }
}
