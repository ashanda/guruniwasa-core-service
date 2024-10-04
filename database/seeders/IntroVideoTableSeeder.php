<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntroVideoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Student items
            ['type' => 'student', 'title' => 'Live Class'],
            ['type' => 'student', 'title' => 'Video Recording'],
            ['type' => 'student', 'title' => 'Class Tute and Books'],
            ['type' => 'student', 'title' => 'Class Paper'],
            ['type' => 'student', 'title' => 'Talent'],
            ['type' => 'student', 'title' => 'Notes @ Paper Answers'],
            ['type' => 'student', 'title' => 'Learning Managements'],
            ['type' => 'student', 'title' => 'Online Exam'],
            ['type' => 'student', 'title' => 'Attendance'],
            ['type' => 'student', 'title' => 'Teachers & New Subjects'],
            ['type' => 'student', 'title' => 'Notice Board'],
            ['type' => 'student', 'title' => 'Class Fee'],
            ['type' => 'student', 'title' => 'Teacher Reviews'],
            ['type' => 'student', 'title' => 'Final Analysis Report'],
            ['type' => 'student', 'title' => 'Time Table'],
            ['type' => 'student', 'title' => 'Item Shop'],

            // Teacher items
            ['type' => 'teacher', 'title' => 'Link Zoom Meeting'],
            ['type' => 'teacher', 'title' => 'Youtube Call Video'],
            ['type' => 'teacher', 'title' => 'Note @ Paper Answers'],
            ['type' => 'teacher', 'title' => 'Upload Tute & Books'],
            ['type' => 'teacher', 'title' => 'Upload Class Papers'],
            ['type' => 'teacher', 'title' => 'Create Online Exam'],
            ['type' => 'teacher', 'title' => 'Student Analysis'],
            ['type' => 'teacher', 'title' => 'Student Details'],
            ['type' => 'teacher', 'title' => 'Notice Board'],
            ['type' => 'teacher', 'title' => 'Birth Days'],
            ['type' => 'teacher', 'title' => 'Student Approvals'],
            ['type' => 'teacher', 'title' => 'Time Tables'],
            ['type' => 'teacher', 'title' => 'Class Fees'],
            ['type' => 'teacher', 'title' => 'Salary Slip'],
            ['type' => 'teacher', 'title' => 'Item Shop'],
            ['type' => 'teacher', 'title' => 'Scan QR'],

            // Staff items
            ['type' => 'staff', 'title' => 'Class Fees'],
            ['type' => 'staff', 'title' => 'Other Transactions'],
            ['type' => 'staff', 'title' => 'LMS Intro Video'],
            ['type' => 'staff', 'title' => 'Student Videos/Certificate'],
            ['type' => 'staff', 'title' => 'Students'],
            ['type' => 'staff', 'title' => 'Teachers'],
            ['type' => 'staff', 'title' => 'Today Live Class'],
            ['type' => 'staff', 'title' => 'Cash Balance'],
            ['type' => 'staff', 'title' => 'My Salary'],
            ['type' => 'staff', 'title' => 'My Attendance'],
            ['type' => 'staff', 'title' => 'Notice Board'],
            ['type' => 'staff', 'title' => 'Birth Days'],
            ['type' => 'staff', 'title' => 'Item Shop'],

            // Admin items
            ['type' => 'admin', 'title' => 'Finance'],
            ['type' => 'admin', 'title' => 'Employees'],
            ['type' => 'admin', 'title' => 'Teachers'],
            ['type' => 'admin', 'title' => 'Students'],
            ['type' => 'admin', 'title' => 'Special Approvals'],
            ['type' => 'admin', 'title' => 'Item Shop'],
            ['type' => 'admin', 'title' => 'Notice Board'],
            ['type' => 'admin', 'title' => 'Birth Days'],
            ['type' => 'admin', 'title' => 'Class Fees'],
            ['type' => 'admin', 'title' => 'Other Transactions'],
            ['type' => 'admin', 'title' => 'Student Approvals'],
            ['type' => 'admin', 'title' => 'LMS Intro Video'],
            ['type' => 'admin', 'title' => 'Create Account'],
        ];

        // Insert the items into the 'items' table
        DB::table('intro_videos')->insert($items);
    }
}
