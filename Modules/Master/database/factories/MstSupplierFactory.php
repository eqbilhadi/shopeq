<?php

namespace Modules\Master\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MstSupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Master\app\Models\MstSupplier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => "PT. " . fake()->company(),
            'phone' => fake()->tollFreePhoneNumber(),
            'address' => fake()->address(),
        ];
    }
}
