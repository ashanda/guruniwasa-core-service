<?php

namespace App\Console\Commands;

use App\Models\VideoRecIssues;
use App\Models\VideoRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VideoIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:video-issues';

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
        $currentDay = Carbon::now()->format('Y-m-d');

        // Fetch lessons where class_status is 'Not Scheduled' and lesson_date is today
        $lessons = VideoRecord::where('status', 'Still Not Added')
            ->whereDate('created_at', $currentDay)
            ->get();

        // Loop through each lesson and update class_status
        foreach ($lessons as $lesson) {
            VideoRecIssues::create([  // Assuming you're creating a new ScheduledLesson record      
                'lesson_id' => $lesson->id,
                'created_at' => Carbon::now(), // Use current timestamp
                'updated_at' => Carbon::now(),
            ]);

            // Optionally, update class_status to "Scheduled" to avoid duplication
           
        }

        $this->info('Class Video Issue created successfully.');
    }
}
