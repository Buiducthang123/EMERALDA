<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CancellationRequestStatus;

class CancellationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'room_id',
        'user_id',
        'reason',
        'status',
    ];

    protected $casts = [
        'status' => CancellationRequestStatus::class,
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
}
