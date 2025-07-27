<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $companyId = Company::inRandomOrder()->value('id');

        return [
            'company_id' => $companyId ?? Company::factory(),
            'product_name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 500),
            'stock' => $this->faker->numberBetween(0, 100),
            'comment' => $this->faker->optional()->sentence(),
            'img_path' => null,
        ];
    }
}
