<?php

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
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
        //Hóa đơn
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // liên kết với bảng bookings
            $table->json('services')->nullable(); // dịch vụ
            $table->decimal('total_amount', 8, 2); // tổng số tiền
            $table->enum('type',  InvoiceType::getValues()); // loại hóa đơn
            $table->enum('status', InvoiceStatus::getValues())->default(InvoiceStatus::UNPAID); // trạng thái hóa đơn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('invoices');
    }
};
