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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // mã voucher
            $table->decimal('discount_amount', 8, 2); // số tiền giảm giá
            $table->date('valid_from'); // ngày bắt đầu hiệu lực
            $table->date('valid_until'); // ngày hết hạn
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('vouchers');
    }
};
