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
        Schema::create('room_type_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // người dùng
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade'); // loại phòng
            $table->integer('rating')->unsigned()->default(0)->nullable()->between(1, 5); // rating
            $table->text('comment')->nullable(); // nội dung đánh giá
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_type_reviews');
    }
};
