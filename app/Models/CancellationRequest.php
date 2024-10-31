<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CancellationRequestStatus;
use Ramsey\Uuid\Type\Integer;

class CancellationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'room_id',
        'user_id',
        'refund_amount',
        'status',
    ];

    protected $casts = [

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value)
    {
        return (Integer)$value;
    }
}
