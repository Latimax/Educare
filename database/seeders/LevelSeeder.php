<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Level::insert(
            [
                [
                    'id' => 1,
                    'level_name' => 'Pre Nursery',
                    'short_name' => 'PNUR',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'level_name' => 'Nursery',
                    'short_name' => 'NUR',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'level_name' => 'Primary',
                    'short_name' => 'PRY',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'level_name' => 'Junior Secondary',
                    'short_name' => 'JSS',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'level_name' => 'Senior Secondary',
                    'short_name' => 'SSS',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
