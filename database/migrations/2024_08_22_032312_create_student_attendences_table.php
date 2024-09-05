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
        Schema::create('student_attendences', function (Blueprint $table) {
            $table->id();
            $table->string('lesson_id');
            $table->string('student_id');
            $table->string('subject_id');
            $table->string('teacher_id');
            $table->string('class_type');
            $table->string('attendence');
            $table->string('lesson_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendences');
    }
};
