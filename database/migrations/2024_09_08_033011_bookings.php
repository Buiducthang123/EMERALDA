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
            $table->foreignId(('order_id'))->constrained('orders')->onDelete('cascade');
            $table->foreignId(column: 'user_id')->constrained('users')->onDelete('cascade')->index(); // người dùng
            $table->foreignId(column: 'room_id')->constrained('rooms')->onDelete('cascade'); // phòng
            $table->date(column: 'check_in_date'); // ngày check-in
            $table->date(column: 'check_out_date'); // ngày check-out
            $table->enum('status', BookingStatus::getValues())->default(BookingStatus::NOT_CHECKED_IN); // trạng thái
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
