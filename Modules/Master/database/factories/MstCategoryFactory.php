<?php

namespace Modules\Master\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MstCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Master\app\Models\MstCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->sentence(2);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => random_int(0,1)
        ];
    }
}

