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
        Schema::create('video_rec_issues', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lesson_id');
            $table->longText('issues')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_rec_issues');
    }
};
