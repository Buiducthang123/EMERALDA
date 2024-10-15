<?php
namespace App\Repositories;

use App\Models\Booking;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderRepository extends BaseRepository{

    public function getModel()
    {
        return Order::class;
    }

    public function getMyOrders($user_id)
    {
        return $this->model->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->with('payment') // Sử dụng 'with' để tải mối quan hệ
            ->get();
    }

}
