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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('gid');
            $table->integer('tid');
            $table->string('sname');
            $table->string('fee');
            $table->string('retention');
            $table->integer('fees_valid_period')->default(45);
            $table->string('whats_app');
            $table->string('class_type');

            $table->string('day_normal');
            $table->string('start_normal');
            $table->string('end_normal');

            $table->string('day_extra1')->nullable();
            $table->string('start_extra1')->nullable();
            $table->string('end_extra1')->nullable();
            $table->string('day_extra1_status')->default('0');

            $table->string('day_extra2')->nullable();
            $table->string('start_extra2')->nullable();
            $table->string('end_extra2')->nullable();
            $table->string('day_extra2_status')->default('0');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
