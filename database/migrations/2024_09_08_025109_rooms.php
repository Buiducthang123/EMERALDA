<?php

use App\Enums\RoomStatus;
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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique(); // số phòng
            $table->foreignId('room_type_id')->constrained('room_types'); // loại phòng
            $table->string('main_image')->nullable(); // ảnh chính
            $table->json('thumbnails')->nullable(); // nhiều thumbnail
            $table->enum('status', RoomStatus::getValues())->default(RoomStatus::AVAILABLE); // trạng thái
            $table->decimal('price', 8, 2); // giá
            $table->text('description')->nullable(); // mô tả
            $table->json('amenities')->nullable(); // tiện nghi trong phòng
            $table->integer('adults')->default(0); // số người lớn
            $table->integer('children')->default(0); // số trẻ em
            $table->integer('area')->nullable();  //diện tích
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
