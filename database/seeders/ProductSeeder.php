<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstUnit;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = MstProduct::factory()->create();
            $unitProduct = [
                'unitable_type' => MstProduct::class,
                'unitable_id' => $product->id,
                'unit_id' => MstUnit::inRandomOrder()->value('id'),
            ];
            $product->units()->create($unitProduct);
        }
        $this->command->info('Product seeded.');
    }
}
