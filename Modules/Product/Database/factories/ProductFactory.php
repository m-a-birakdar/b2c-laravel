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
            'title' => $this->faker->name,
            'sku' => $this->faker->buildingNumber,
            'status' => $this->faker->randomElement([true, false]),
            'thumbnail' => $this->faker->imageUrl,
            'price' => $this->faker->numberBetween(100,1000),
            'discount' => $this->faker->numberBetween(1,2),
        ];
    }
}

