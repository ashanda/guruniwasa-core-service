<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheduled_lessons', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('lesson_title');
            $table->date('lesson_date');
            $table->string('day_of_week'); // e.g., 'Monday', 'Tuesday', etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->string('zoom_link')->nullable();
            $table->string('password')->nullable();
            $table->string('class_status')->nullable();
            $table->text('special_note')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_type')->nullable(); // e.g., 'daily', 'weekly'
            $table->string('status')->default('Still Not Scheduled');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_lessons');
    }
};
