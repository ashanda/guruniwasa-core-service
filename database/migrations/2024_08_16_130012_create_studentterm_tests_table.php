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
            $table->string('first_term_paper');
            $table->string('first_term_mark');
            $table->string('second_term_paper');
            $table->string('second_term_mark');
            $table->string('third_term_paper');
            $table->string('third_term_mark');
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
