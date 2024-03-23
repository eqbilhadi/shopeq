<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Master\app\Models\MstProduct;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MstProduct::factory()->count(50)->create();
        $this->command->info('Product seeded.');
    }
}
