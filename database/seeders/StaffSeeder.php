<?php

namespace Database\Seeders;

use App\Models\SchoolInfo;
use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can use the factory to create staff records
        // \App\Models\Staff::factory(10)->create();

        //StaffId should be unique and should be in the format of school code / year / staffId

        // Example: SCH/2025/001

        $short_name = SchoolInfo::first()->short_name;

        //Get the id of the last staff created
        $last_staff = Staff::orderBy('id', 'desc')->first();

        //Get the last staffId and format it in 3 digits

        if ($last_staff) {
            $last_staffId = $last_staff->staffId;
            $last_staff_number = (int) substr($last_staffId, strrpos($last_staffId, '/') + 1);
            $new_staff_number = str_pad($last_staff_number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $new_staff_number = '001';
        }

        Staff::create([
            'staffId' => $short_name . '/STF/'. $new_staff_number,
            'fullname' => 'John Doe',
            'password' => bcrypt('password'), // Use bcrypt for password hashing
            'email' =>  fake()->unique()->safeEmail(),
            'status' => 'active',
            'user_type' => 'teacher',
            'phone' => '08012345678',
            'dob' => '1990-01-01',
            'state' => 'Lagos',
            'country' => 'Nigeria',

        ]);

    }
}
