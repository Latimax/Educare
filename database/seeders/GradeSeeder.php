<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Grade A-F except E

        Grade::create([
            'grade_name' => 'A',
            'description' => 'Excellent',
            'min_score' => 70,
            'max_score' => 100,
        ]);
        Grade::create([
            'grade_name' => 'B',
            'description' => 'Very Good',
            'min_score' => 60,
            'max_score' => 69,
        ]);

        Grade::create([
            'grade_name' => 'C',
            'description' => 'Good',
            'min_score' => 50,
            'max_score' => 59,
        ]);

        Grade::create([
            'grade_name' => 'D',
            'description' => 'Fair',
            'min_score' => 40,
            'max_score' => 49,
        ]);
        Grade::create([
            'grade_name' => 'F',
            'description' => 'Fail',
            'min_score' => 0,
            'max_score' => 39,
        ]);
    }
}
