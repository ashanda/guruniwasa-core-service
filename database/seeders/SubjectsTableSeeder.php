<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('subjects')->insert([
            [
                'gid' => '1',
                'tid' => '2',
                'sname' => 'Mathematics',
                'fee' => '100',
                'fees_valid_period' => 45,
                'whats_app' => '1234567890',
                'class_type' => 'Online',
                'day_normal' => 'Monday',
                'start_normal' => '08:00 AM',
                'end_normal' => '09:00 AM',
                'day_extra1' => 'Wednesday',
                'start_extra1' => '08:00 AM',
                'end_extra1' => '09:00 AM',
                'day_extra1_status' => '1',
                'day_extra2' => 'Friday',
                'start_extra2' => '08:00 AM',
                'end_extra2' => '09:00 AM',
                'day_extra2_status' => '1',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gid' => '2',
                'tid' => '2',
                'sname' => 'Science',
                'fee' => '150',
                'fees_valid_period' => 45,
                'whats_app' => '1234567891',
                'class_type' => 'Offline',
                'day_normal' => 'Tuesday',
                'start_normal' => '10:00 AM',
                'end_normal' => '11:00 AM',
                'day_extra1' => 'Thursday',
                'start_extra1' => '10:00 AM',
                'end_extra1' => '11:00 AM',
                'day_extra1_status' => '1',
                'day_extra2' => null,
                'start_extra2' => null,
                'end_extra2' => null,
                'day_extra2_status' => '0',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
             [
                'gid' => '2',
                'tid' => '2',
                'sname' => 'Science',
                'fee' => '150',
                'fees_valid_period' => 45,
                'whats_app' => '1234567891',
                'class_type' => 'Offline',
                'day_normal' => 'Tuesday',
                'start_normal' => '10:00 AM',
                'end_normal' => '11:00 AM',
                'day_extra1' => 'Thursday',
                'start_extra1' => '10:00 AM',
                'end_extra1' => '11:00 AM',
                'day_extra1_status' => '1',
                'day_extra2' => null,
                'start_extra2' => null,
                'end_extra2' => null,
                'day_extra2_status' => '0',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more subjects as needed
        ]);
    }
}
