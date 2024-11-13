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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique();
            $table->string('slug',50)->unique();
            $table->string('intro_description')->nullable(); // mô tả ngắn
            $table->string('main_image');
            $table->json('thumbnails');
            $table->json('amenities')->nullable(); // tiện nghi trong phòng
            $table->unsignedInteger('max_people')->default(3); // Số người tối đa
            $table->decimal('price', 8, 2); // giá
            $table->unsignedInteger('area'); // diện tích
            $table->text('description')->nullable(); // mô tả
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Schema::dropIfExists('room_types');
    }
};
