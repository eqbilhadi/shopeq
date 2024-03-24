<?php

namespace Modules\Master\database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Master\app\Models\MstCategory;

class MstProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Master\app\Models\MstProduct::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => MstCategory::inRandomOrder()->value('id'),
            'name' => ucwords(fake()->words(2, true)),
            'description' => fake()->paragraphs(12, true),
            'barcode' => fake()->randomNumber(9, true),
            'selling_price' => fake()->numberBetween(50000, 500000),
            'purchase_price' => fake()->numberBetween(50000, 500000),
            'minimal_stok' => random_int(10, 50),
            'status' => fake()->randomElement(['published', 'draft']),
            'visibility' => fake()->randomElement(['public', 'hidden']),
            'created_by' => User::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id')
        ];
    }
}
