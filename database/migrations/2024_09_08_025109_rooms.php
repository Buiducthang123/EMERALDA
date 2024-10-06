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
            $table->foreignId(column: 'room_type_id')->constrained('room_types'); // loại phòng
            $table->enum('status', RoomStatus::getValues())->default(RoomStatus::AVAILABLE); // trạng thái
            $table->text(column: 'description')->nullable(); // mô tả
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
