<?php

use App\Enums\BookingStatus;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // người dùng
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // phòng
            $table->date('check_in_date'); // ngày check-in
            $table->date('check_out_date'); // ngày check-out
            $table->enum('status', BookingStatus::getValues())->default(BookingStatus::PENDING); // trạng thái đặt phòng
            $table->integer('adults'); // số người lớn
            $table->integer('children')->default(0); // số trẻ em
            $table->decimal('total_price', 8, 2); // tổng giá
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
