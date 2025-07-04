<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Junior Secondary Subjects
        Subject::insert(
            [
                [
                    'subject_name' => 'Mathematics',
                    'subject_code' => 'MAT101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'English Language',
                    'subject_code' => 'ENG101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Basic Science',
                    'subject_code' => 'BAS101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Basic Technology',
                    'subject_code' => 'BST101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Social Studies',
                    'subject_code' => 'SOC101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Computer Studies',
                    'subject_code' => 'COM101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Physical & Health Education',
                    'subject_code' => 'PHE101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Agricultural Science',
                    'subject_code' => 'AGR101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Business Studies',
                    'subject_code' => 'BUS101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Culturea & Creative Arts',
                    'subject_code' => 'ART101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Home Economics',
                    'subject_code' => 'HOM101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'French Language',
                    'subject_code' => 'FRE101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'disabled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Civic Education',
                    'subject_code' => 'CIV101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Christian Religious Knowledge',
                    'subject_code' => 'CRK101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Islamic Religious Knowledge',
                    'subject_code' => 'IRK101',
                    'staff_id' => null,
                    'level_id' => 4,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );

        //Senior Secondary Subjects
        Subject::insert(
            [
                [
                    'subject_name' => 'Mathematics',
                    'subject_code' => 'MAT201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'English Language',
                    'subject_code' => 'ENG201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Chemistry',
                    'subject_code' => 'CHE201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Physics',
                    'subject_code' => 'PHY201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Biology',
                    'subject_code' => 'BIO201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Economics',
                    'subject_code' => 'ECO201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Geography',
                    'subject_code' => 'GEO201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Government',
                    'subject_code' => 'GOV201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'History',
                    'subject_code' => 'HIS201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'disabled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Agricultural Science',
                    'subject_code' => 'AGR201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Christian Religious Knowledge',
                    'subject_code' => 'CRK201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Islamic Religious Knowledge',
                    'subject_code' => 'IRK201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Civic Education',
                    'subject_code' => 'CIV201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Financial Accounting',
                    'subject_code' => 'FIN201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Further Mathematics',
                    'subject_code' => 'FUR201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'disabled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Marketing',
                    'subject_code' => 'MAR201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Commerce',
                    'subject_code' => 'COM201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'disabled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'subject_name' => 'Literature in English',
                    'subject_code' => 'LIT201',
                    'staff_id' => null,
                    'level_id' => 5,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );


        // Subject::insert(
        //     [
        //         [
        //             'id' => 1,
        //             'level_name' => 'Pre Nursery',
        //             'short_name' => 'PNUR',
        //             'status' => 'active',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ],
        //         [
        //             'id' => 2,
        //             'level_name' => 'Nursery',
        //             'short_name' => 'NUR',
        //             'status' => 'active',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ],
        //         [
        //             'id' => 3,
        //             'level_name' => 'Primary',
        //             'short_name' => 'PRY',
        //             'status' => 'active',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ],
        //         [
        //             'id' => 4,
        //             'level_name' => 'Junior Secondary',
        //             'short_name' => 'JSS',
        //             'status' => 'active',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ],
        //         [
        //             'id' => 5,
        //             'level_name' => 'Senior Secondary',
        //             'short_name' => 'SSS',
        //             'status' => 'active',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ],
        //     ]
        // );
    }
}
