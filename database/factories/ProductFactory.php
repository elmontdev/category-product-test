<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"        => $this->faker->unique()->word(),
            "description" => $this->faker->sentence(),
            "price"       => $this->faker->randomFloat(2, 1, 1000),
            "image_url"   => "image",
            // "category_id" => Category::query()->first()->value('id'),
            "category_id" => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
