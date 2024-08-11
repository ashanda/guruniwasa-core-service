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
        Schema::create('video_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduled_lesson_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('lesson_title');
            $table->string('video_url1')->nullable();
            $table->string('video_url2')->nullable();
            $table->string('status')->default('Still Not Added');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_records');
    }
};
