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
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // đơn hàng
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // người dùng
            $table->float('amount'); // số tiền
            $table->enum('status', PaymentStatus::getValues())->default(value: PaymentStatus::UNPAID); // trạng thái thanh toán
            $table->string('transaction_id',20)->nullable(); // mã giao dịch
            $table->unsignedBigInteger('payment_date')->nullable(); // ngày thanh toán
            $table->unsignedBigInteger('id_ref')->nullable(); // id hoàn tiền
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
