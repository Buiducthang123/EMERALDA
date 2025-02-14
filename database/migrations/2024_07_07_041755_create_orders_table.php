<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->json(column: 'room_ids');
            $table->json('customer_info'); // thông tin khách hàng
            $table->string('voucher_code',20)->nullable(); // mã giảm giá
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // người dùng
            $table->float('total_price'); // tổng giá
            $table->float('payable_amount'); // số phải trả
            $table->float('prepayment_amount')->default(0); // số tiền đã thanh toán
            $table->enum('status', OrderStatus::getValues())->default(OrderStatus::PENDING); // trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
