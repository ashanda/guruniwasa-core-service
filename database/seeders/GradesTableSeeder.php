<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->insert([
            ['gname' => 'Grade 1', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 2', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 3', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 4', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 5', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 6', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 7', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 8', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 9', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 10', 'created_at' => now(), 'updated_at' => now()],
            ['gname' => 'Grade 11', 'created_at' => now(), 'updated_at' => now()],

            // Add more grades as needed
        ]);
    }
}
