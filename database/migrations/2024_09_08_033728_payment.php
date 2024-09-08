<?php

use App\Enums\PaymentStatus;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // đặt phòng
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // người dùng
            $table->decimal('amount', 8, 2); // số tiền
            $table->enum('status', PaymentStatus::getValues())->default(PaymentStatus::PENDING); // trạng thái thanh toán
            $table->string('transaction_id')->nullable(); // mã giao dịch
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
