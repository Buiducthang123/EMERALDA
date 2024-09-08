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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // tên tiện nghi
            $table->text('description')->nullable(); // mô tả
            $table->timestamps();
        });

        Schema::create('amenity_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // phòng
            $table->foreignId('amenity_id')->constrained('amenities')->onDelete('cascade'); // tiện nghi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_room');
        Schema::dropIfExists('amenities');
    }
};
