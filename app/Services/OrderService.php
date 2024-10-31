<?php
namespace App\Services;

use App\Http\Controllers\PaymentController;
use App\Models\Order;
use App\Models\Room;
use App\Models\Voucher;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderService
{

    protected $orderRepository;

    protected $paymentController;

    protected $bookingService;

    public function __construct(OrderRepository $orderRepository, PaymentController $paymentController, BookingService $bookingService)
    {
        $this->orderRepository = $orderRepository;
        $this->paymentController = $paymentController;
        $this->bookingService = $bookingService;
    }

    public function createOrder($data)
    {
        // Validate data
        $validator = Validator::make($data, [
            'room_ids' => 'required|array',
            'customer_info' => 'required|array',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data['user_id'] = Auth::id();

        if ($data['user_id'] == null) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thực hiện chức năng này'], 401);
        }

        $customer_info = $data['customer_info'];
        if (empty($customer_info['name']) || empty($customer_info['email']) || empty($customer_info['phone_number']) || empty($customer_info['address']) || empty($customer_info['birthday'])) {
            return response()->json(['message' => 'Vui lòng nhập đủ thông tin khách hàng'], 400);
        }

        if (count($data['room_ids']) == 0) {
            return response()->json(['message' => 'Vui lòng chọn ít nhất 1 phòng'], 400);
        }

        $rooms = Room::whereIn('id', $data['room_ids'])->with('roomType')->get();
        if ($rooms->isEmpty()) {
            return response()->json(['message' => 'Phòng không tồn tại'], 400);
        }

        // kiểm tra xem phòng đã được đặt chưa
        $room_ids = $data['room_ids'];
        $check_in_date = $data['check_in_date'];
        $check_out_date = $data['check_out_date'];

        $roomBooked = $this->bookingService->checkRoomBooked($room_ids, $check_in_date, $check_out_date);

        if($roomBooked){
            return response()->json([
                'message' => 'Phòng đã được đặt vui lòng chọn phòng khác',
                'roomBooked' => $roomBooked
            ], 400);
        }

        $total_price = $rooms->sum(function ($room) {
            return $room->roomType->price;
        });

        $discount = 0;
        if (!empty($data['voucher_code'])) {
            $voucher = Voucher::where('code', $data['voucher_code'])->first();
            if ($voucher) {
                if(!Carbon::now()->between($voucher->valid_from, $voucher->valid_until))
                {
                    return response()->json(['message' => 'Voucher đã hết hạn'], 400);
                }
                $discount = $voucher->discount_amount;
            } else {
                return response()->json(['message' => 'Voucher không hợp lệ'], 400);
            }
        }

        $data['total_price'] = $total_price;
        $data['payable_amount'] = $total_price - ($total_price * $discount / 100);

        // Đặt cọc 30% giá trị đơn hàng

        try {
            $order = Order::create($data);

            // Call payment controller to create payment

            if($order){
                $paymentData = [
                    'amount' => $data['payable_amount'] * 0.3,
                    'order_id' => $order->id,
                    'ip' => $data['ip'],
                    'discount' => $discount,
                    'user_id' => $data['user_id'],
                    'check_in_date' => $data['check_in_date'],
                    'check_out_date' => $data['check_out_date'],
                ];

               $url =  $this->paymentController->createPayment($paymentData);

               return response()->json(['url' => $url]);

            }

        } catch (\Exception $e) {
            Log::error('Error creating order', ['exception' => $e]);
            return response()->json(['error' => 'Đã xảy ra lỗi khi tạo đơn hàng'], 500);
        }
    }

    public function getMyOrders($user_id)
    {
        return $this->orderRepository->getMyOrders($user_id);
    }

}
