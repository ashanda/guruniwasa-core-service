<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'tid' => 1,
                'gid' => 2,
                'sid' => 2,
                'title' => 'Mathematics Lesson 1',
                'lesson_date' => Carbon::today()->toDateString(),
                'start_time' => Carbon::now()->addHour()->toTimeString(),
                'end_time' => Carbon::now()->addHours(2)->toTimeString(),
                'link' => 'http://example.com/lesson1',
                'password' => Str::random(8),
                'special_note' => 'Bring your textbooks',
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tid' => 1,
                'gid' => 2,
                'sid' => 1,
                'title' => 'Science Lesson 1',
                'lesson_date' => Carbon::today()->toDateString(),
                'start_time' => Carbon::now()->addHours(3)->toTimeString(),
                'end_time' => Carbon::now()->addHours(4)->toTimeString(),
                'link' => 'http://example.com/lesson2',
                'password' => Str::random(8),
                'special_note' => 'Prepare your lab equipment',
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
