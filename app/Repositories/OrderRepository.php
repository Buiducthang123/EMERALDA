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


}
