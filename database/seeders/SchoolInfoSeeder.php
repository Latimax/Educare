<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\SchoolInfo::create([
            'school_name' => 'Reliable Cornerstone Schools',
            'short_name' => 'RCS',
            'owner_name' => 'Shaibu Abdullateef',
            'school_motto' => 'Wisdom is Strength',
            'school_type' => 'combined',
            'address' => 'KM3, Serado Street, Igbira Camp, Auchi, Edo State',
            'city' => 'Auchi',
            'state' => 'Edo State',
            'lga' => 'Etsako LGA',
            'country' => 'Nigeria',
            'latitude' => 9.082,
            'longitude' => 8.6753,
            'year_established' => 2006,
            'phone' => '+2341234567890',
            'phone_alt' => '+2340987654321',
            'email' => '',
            'meta_description' => 'RCS School is a premier educational institution.',
            'meta_keywords' => 'school, education, learning',
            'facebook' => 'https://facebook.com/testschool',
            'youtube' => 'https://youtube.com/testschool',
            'whatsapp' => 'https://wa.me/2341234567890',
            'website' => 'https://testschool.com',
            'google_map_src' => 'https://maps.google.com/?q=9.082,8.6753',
        ]);


    }
}
