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
        Schema::create('studentterm_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id');
            $table->bigInteger('subject_id');
            $table->bigInteger('teacher_id');
            $table->bigInteger('grade_id');
            $table->string('first_term')->nullable();
            $table->string('first_marks')->nullable();
            $table->string('second_term')->nullable();
            $table->string('second_marks')->nullable();
            $table->string('third_term')->nullable();
            $table->string('third_marks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentterm_tests');
    }
};
