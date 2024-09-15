<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduledLessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $data = [
            [
                'teacher_id' => 1,
                'grade_id' => 1,
                'subject_id' => 1,
                'lesson_title' => 'Math Lesson',
                'lesson_date' => $now->toDateString(),
                'day_of_week' => 'Monday',
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'zoom_link' => 'http://example.com/zoom1',
                'password' => 'password123',
                'class_status' => 'Scheduled',
                'special_note' => 'Chapter 1: Introduction',
                'is_recurring' => true,
                'recurrence_type' => 'weekly',
                'status' => 'Still Not Scheduled', // added status
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'teacher_id' => 1,
                'grade_id' => 2,
                'subject_id' => 2,
                'lesson_title' => 'Science Lesson',
                'lesson_date' => $now->addDay()->toDateString(),
                'day_of_week' => 'Tuesday',
                'start_time' => '11:00:00',
                'end_time' => '12:00:00',
                'zoom_link' => 'http://example.com/zoom2',
                'password' => 'password456',
                'class_status' => 'Scheduled',
                'special_note' => 'Chapter 2: The Solar System',
                'is_recurring' => true,
                'recurrence_type' => 'weekly',
                'status' => 'Still Not Scheduled', // added status
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Add more sample data as needed
        ];

        DB::table('scheduled_lessons')->insert($data);
    }
}
