<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CbtConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Use DB Facade to insert data directly into the cbt_configs table

        DB::table('cbt_configs')->insert([
            'ft_status' => true,
            'st_status' => true,
            'exam_status' => true,
            'total_time' => 20, // Total time for the test in minutes
            'attempts_allowed' => 1, // Number of attempts allowed
            'shuffle_questions' => true, // Shuffle questions
            'shuffle_answers' => true, // Shuffle answers
            'show_correct_answers' => true, // Show correct answers after test
            'ft_total_questions' => 10, // Total questions for First Test
            'st_total_questions' => 10, // Total questions for Second Test
            'exam_total_questions' => 20, // Total questions for Exam
        ]);

    }
}
