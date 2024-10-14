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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained('users')->onDelete('cascade')->index(); // người dùng
            $table->json(column: 'customer_info'); // thông tin khách hàng
            $table->foreignId(column: 'room_id')->constrained('rooms')->onDelete('cascade'); // phòng
            $table->date(column: 'check_in_date'); // ngày check-in
            $table->date(column: 'check_out_date'); // ngày check-out
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
