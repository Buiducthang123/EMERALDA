<?php

namespace App\Http\Controllers;

use App\Enums\CancellationRequestStatus;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceType;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\CancellationRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Room;
use App\Services\PaymentService;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    //
    public function createPayment($data)
    {
        $order_id = $data['order_id'];
        $ip = $data['ip'];
        $amount =  $data['amount'];

        if($order_id == null) {
            return response()->json(['error' => 'Order ID is required'], 400);
        }

        $user_id = $data['user_id'];


        $orderInfo = [
            'order_id' => $order_id,
            'user_id' => $user_id,
            'discount' => $data['discount'] ?? 0,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
        ];

        Payment::create([
            'order_id' => $orderInfo['order_id'],
            'user_id' => $orderInfo['user_id'],
            'amount' => $amount,
        ]);

        $vnpayConfig = config('services.vnpay');
        $vnp_TmnCode =  $vnpayConfig['tmn_code']; // Mã website tại VNPAY
        $vnp_HashSecret = $vnpayConfig['hash_secret']; // Chuỗi bí mật
        $vnp_Url = $vnpayConfig['url'];
        $vnp_Returnurl = url('http://localhost:3000/booking');
        $vnp_TxnRef = $order_id; // Mã đơn hàng
        $vnp_OrderInfo = json_encode($orderInfo); // Thông tin đơn hàng
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount * 100; // Số tiền thanh toán (nhân với 100 để chuyển sang đơn vị VNĐ)
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $ip;
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire,
            // 'vnp_CreateBy' => 1
        );

        if(isset($data['bank_code']) &&$data['bank_code'] != null) {
            $inputData['bank_code'] = $data['bank_code'];
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {

        $vnpayConfig = config('services.vnpay');
        $vnp_HashSecret = $vnpayConfig['hash_secret']; // Chuỗi bí mật

        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);


        if ($secureHash == $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                // Lấy thông tin thanh toán từ cơ sở dữ liệu
                $paymentDate = Carbon::createFromFormat('YmdHis', $inputData['vnp_PayDate'])->toDateTimeString();

                $order_info = json_decode($inputData['vnp_OrderInfo'], true);

                $payment = Payment::where('order_id', $order_info['order_id'])->first();

                // return $payment;

                // return $inputData;
                if ($payment) {
                    $payment->update([
                        'status' => PaymentStatus::DEPOSIT,
                        'transaction_id' =>$inputData['vnp_TransactionNo'],
                        'payment_date' => $inputData['vnp_PayDate'],
                        'id_ref' => $inputData['vnp_TxnRef'],
                    ]);

                    $order = Order::find($payment->order_id);
                    if ($order) {
                        $order->prepayment_amount = $payment->amount;
                        $order->status = OrderStatus::CONFIRMED;
                        $order->save();
                    }
                    // return $order->voucher_code;
                    $discount = $order_info['discount'];
                    $dataBooking = []  ;

                    foreach ($order->room_ids as $key => $value) {
                        $total_price = Room::find($value)->roomType->price;

                        $total_price = $total_price - ($total_price * $discount / 100);

                        $paid_amount = $total_price * 0.3;

                        $dataBooking[] = [
                            'room_id' => $value,
                            'check_in_date' => $order_info['check_in_date'],
                            'check_out_date' => $order_info['check_out_date'],
                            'total_price' => $total_price,
                            'paid_amount' => $paid_amount,
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                        ];
                    }

                    if ($dataBooking) {
                        foreach ($dataBooking as $bookingData) {
                            Booking::firstOrCreate(
                                [
                                    'room_id' => $bookingData['room_id'],
                                    'check_in_date' => $bookingData['check_in_date'],
                                    'check_out_date' => $bookingData['check_out_date'],
                                    'order_id' => $bookingData['order_id'],
                                    'user_id' => $bookingData['user_id']
                                ],
                                $bookingData
                            );
                        }
                    }
                    return $dataBooking;

                }


            } else {
                // Thanh toán thất bại
                return response()->json(['message' => 'Thanh toán thất bại'], 400);
            }
        } else {
            // Sai chữ ký
            return response()->json(['message' => 'Sai chũ kí'], 400);
        }
    }

    public function getAllPayment(Request $request)
    {
        return $this->paymentService->getAllPayment($request->all());
    }

    public function refund(Request $request)
    {
        $booking = Booking::where('order_id', $request->order_id)->where('room_id', $request->room_id)->first();
        $payment = Payment::where('order_id', $request->order_id)->first();
        $user = Auth::user();

        if (!$booking || !$payment) {
            return response()->json(['error' => 'Invalid booking or payment details'], 400);
        }

        $vnpayConfig = config('services.vnpay');
        $vnp_TmnCode = $vnpayConfig['tmn_code']; // Mã website tại VNPAY
        $vnp_HashSecret = $vnpayConfig['hash_secret']; // Chuỗi bí mật

        $vnp_ApiUrl = 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction';
        $vnp_RequestId = rand(1, 10000);  // ID yêu cầu
        $vnp_Command = 'refund';  // API command
        $vnp_TransactionType = '03'; // Loại giao dịch (03 là hoàn tiền)
        $vnp_TxnRef = $payment->id_ref;  // Mã giao dịch cần hoàn tiền
        $vnp_Amount = 6000 * 100;  // Số tiền hoàn, phải nhân 100
        $vnp_OrderInfo = 'Hoàn tiền giao dịch ' . $vnp_TxnRef;
        $vnp_CreateDate = now()->format('YmdHis');
        $vnp_IpAddr = $request->ip();
        $vnp_TransactionDate = $payment->payment_date; // Ngày giao dịch ban đầu

        $inputData = [
            "vnp_RequestId" => $vnp_RequestId,
            "vnp_Version" => "2.1.0",
            "vnp_Command" => $vnp_Command,
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_TransactionType" => $vnp_TransactionType,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_Amount" => $vnp_Amount,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_TransactionDate" => $vnp_TransactionDate,
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CreateBy" => $user->id,
        ];

        // Tạo chuỗi dữ liệu để tạo checksum
        $hashData = implode('|', [
            $inputData['vnp_RequestId'],
            $inputData['vnp_Version'],
            $inputData['vnp_Command'],
            $inputData['vnp_TmnCode'],
            $inputData['vnp_TransactionType'],
            $inputData['vnp_TxnRef'],
            $inputData['vnp_Amount'],
            '', // vnp_TransactionNo (optional)
            $inputData['vnp_TransactionDate'],
            $inputData['vnp_CreateBy'],
            $inputData['vnp_CreateDate'],
            $inputData['vnp_IpAddr'],
            $inputData['vnp_OrderInfo']
        ]);

        // Tạo SecureHash với SHA512 và khóa bí mật
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Thêm chữ ký bảo mật vào inputData
        $inputData['vnp_SecureHash'] = $secureHash;

        // Gửi yêu cầu tới VNPay
        $response = Http::post($vnp_ApiUrl, $inputData);

        // Xử lý kết quả
        if ($response->successful()) {
            $responseData = $response->json();
            $vnp_ResponseCode = $responseData['vnp_ResponseCode'] ?? null;
            $vnp_Message = $responseData['vnp_Message'] ?? null;

            if ($vnp_ResponseCode === '00') {
                DB::transaction(function () use ($request, $vnp_Amount, $booking) {
                    Invoice::create([
                        'order_id' => $request->order_id,
                        'amount' => $vnp_Amount,
                        'status' => InvoiceStatus::PAID,
                        'type' => InvoiceType::REFUND,
                        'total_amount' => $vnp_Amount,
                        'booking_id' => $booking->id,
                    ]);

                    $cancelRequest = CancellationRequest::find($request->cancel_request_id);
                    if ($cancelRequest) {
                        $cancelRequest->update(['status' => CancellationRequestStatus::COMPLETED]);
                    }

                    $booking->delete();
                });

                return response()->json(['message' => 'Refund successful', 'vnp_Message' => $vnp_Message], 200);
            } else {
                return response()->json(['error' => 'Refund failed', 'vnp_ResponseCode' => $vnp_ResponseCode, 'vnp_Message' => $vnp_Message], 500);
            }
        } else {
            return response()->json(['error' => 'Refund request failed', 'details' => $response->body()], 500);
        }
    }
}
