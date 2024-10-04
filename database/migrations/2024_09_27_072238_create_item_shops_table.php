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
        Schema::create('item_shops', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name', 255); // Name of the item
            $table->string('code', 255); // Code of the item
            $table->unsignedBigInteger('category_id'); // Foreign key to categories table
            $table->string('commission_account'); // Commission account
            $table->unsignedBigInteger('commission_account_id'); // Commission rate
            $table->decimal('rate', 8, 2); // Rate of commission
            $table->decimal('price', 10, 2); // Price of the item
            $table->decimal('weight', 8, 2); // Weight in KG
            $table->text('details')->nullable(); // Details or description of the item
            $table->string('image_path')->nullable(); // Path to the image file
            $table->softDeletes();
            $table->timestamps(); // cre
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_shops');
    }
};
