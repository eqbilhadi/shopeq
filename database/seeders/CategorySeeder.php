<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Master\app\Models\MstCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MstCategory::factory()->count(10)->create();
        $this->command->info('Categories seeded.');
    }
}
