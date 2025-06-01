<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ClassModel::insert(
            [
                [
                    'class_name' => 'Pre Nursery',
                    'section' => 'A',
                    'class_teacher_id' => 1,
                    'status' => 'active',
                    'level_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'class_name' => 'Nursery 1',
                    'section' => 'A',
                    'class_teacher_id' => 1,
                    'status' => 'active',
                    'level_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'class_name' => 'Primary 1',
                    'section' => 'A',
                    'class_teacher_id' => 1,
                    'status' => 'active',
                    'level_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'class_name' => 'Junior Secondary 1',
                    'section' => 'A',
                    'class_teacher_id' => 1,
                    'status' => 'active',
                    'level_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'class_name' => 'Senior Secondary 1',
                    'section' => 'A',
                    'class_teacher_id' => 1,
                    'status' => 'active',
                    'level_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]
        );
    }
}
