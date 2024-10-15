<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'booking_ids', 'voucher_code', 'customer_info','room_ids', 'total_price', 'payable_amount', 'prepayment_amount', 'status', 'refunded_status'];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    protected $casts = [
        'customer_info' => 'array',
        'room_ids' => 'array',
    ];

}
