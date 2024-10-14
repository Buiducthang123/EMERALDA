<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
    ];


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

        return response()->json([$vnp_Url]);
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

                $orderInfo = json_decode($inputData['vnp_OrderInfo'], true);

                $payment = Payment::create([
                    'order_id' => $orderInfo['order_id'],
                    'user_id' => $orderInfo['user_id'],
                    'amount' => $inputData['vnp_Amount'] / 100,
                    'status' => PaymentStatus::DEPOSIT, // đặt cọc
                    'transaction_id' => $inputData['vnp_TransactionNo'],
                    'payment_date' => $paymentDate
                ]);

                if ($payment) {
                    return response()->json(['message' => 'Thanh toán thành công'], 200);
                } else {
                    // tạo thanh toán thất bại
                    return response()->json(['message' => 'Tạo hóa đơn thất bại'], 400);
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
}
