<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Entities\Category;

class ProductFactory extends Factory
{
    protected $model = \Modules\Product\Entities\Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::query()->whereNotNull('parent_id')->inRandomOrder()->first()->id,
            'city_id' => rand(1, 2),
            'title' => $this->faker->name,
            'sku' => $this->faker->buildingNumber,
            'status' => $this->faker->randomElement([true, false]),
            'rank' => $this->faker->randomElement([0, rand(1, 10)]),
            'thumbnail' => $this->faker->imageUrl,
            'price' => $this->faker->randomFloat(2, 100,1000),
            'discount' => $this->faker->randomFloat(2, 1,10),
        ];
    }
}

