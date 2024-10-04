<?php
namespace App\Console\Commands;

use App\Models\ClassIssues;
use App\Models\ScheduledLesson;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClassIssue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:class-issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current day in 'Y-m-d' format
        $currentDay = Carbon::now()->format('Y-m-d');

        // Fetch lessons where class_status is 'Not Scheduled' and lesson_date is today
        $lessons = ScheduledLesson::where('class_status', 'Not Scheduled')
            ->whereDate('lesson_date', $currentDay)
            ->get();

        // Loop through each lesson and update class_status
        foreach ($lessons as $lesson) {
            ClassIssues::create([  // Assuming you're creating a new ScheduledLesson record      
                'lesson_id' => $lesson->id,
                'created_at' => Carbon::now(), // Use current timestamp
                'updated_at' => Carbon::now(),
            ]);

            // Optionally, update class_status to "Scheduled" to avoid duplication
           
        }

        $this->info('Class Issue created successfully.');
    }
}