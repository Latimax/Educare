<?php

namespace Database\Seeders;

use App\Models\SessionModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSessions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Add Sessions 2025/2026 to 2030-2031

        SessionModel::insert(
            [
                [
                    'session_name' => '2025/2026',
                    'status' => 'active',
                ],
                [
                    'session_name' => '2026/2027',
                    'status' => 'active',
                ],
                [
                    'session_name' => '2027/2028',
                    'status' => 'active',
                ],
                [
                    'session_name' => '2028/2029',
                    'status' => 'active',
                ],
                [
                    'session_name' => '2029/2030',
                    'status' => 'active',
                ],
                [
                    'session_name' => '2030/2031',
                    'status' => 'active',
                ],
            ]);
    }
}
