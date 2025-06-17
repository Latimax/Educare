<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\SchoolSessionController;
use App\Models\Admin;
use App\Models\SchoolInfo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Create an Admin
        //Admin::factory()->count(1)->create();

        // Create different levels
        //  $this->call(LevelSeeder::class);

        //Create School Sessions
        //$this->call(SchoolSessions::class);

        //Create School Information
        // $this->call(SchoolInfoSeeder::class);

        // Create Some Classess
        // $this->call(ClassSeeder::class);

        //Staff seeder
        //$this->call(StaffSeeder::class);

        //Create Subjects
        // $this->call(SubjectSeeder::class);

        // Create Grades
        //$this->call(GradeSeeder::class);

        // Create Result Comments
        //$this->call(ResultCommentSeeder::class);

        // Create Cbt Configurations
        //$this->call(CbtConfigSeeder::class);




    }
}
