<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái phòng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #006197; 
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        h1 {
            color: #ffffff;
            font-size: 28px;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.8;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background: rgba(255, 255, 255, 0.2);
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            display: flex;
            justify-content: space-between;
        }

        ul li strong {
            color: #f39c12;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #f4f4f4;
            text-align: center;
        }

        .footer a {
            color: #f39c12;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cập nhật trạng thái phòng</h1>
        <p>Kính gửi {{ $data['user']['name'] }},</p>
        <p>Trạng thái đặt phòng của bạn đã được cập nhật. Dưới đây là chi tiết:</p>
        <ul>
            <li><strong>Mã đơn hàng:</strong> <span>{{ $data['order_id'] }}</span></li>
            <li><strong>Mã phòng:</strong> <span>{{ $data['room_id'] }}</span></li>
            <li><strong>Ngày nhận phòng:</strong> <span>{{ $data['check_in_date'] }}</span></li>
            <li><strong>Ngày trả phòng:</strong> <span>{{ $data['check_out_date'] }}</span></li>
            <li><strong>Tổng giá trị:</strong> <span>{{ $data['total_price'] }}</span></li>
            <li><strong>Số tiền đã thanh toán:</strong> <span>{{ $data['paid_amount'] }}</span></li>
            @php
                use App\Enums\BookingStatus;
            @endphp
            <li><strong>Trạng thái:</strong> <span>{{ (new BookingStatus())->getLabel($data['status']) }}</span></li>
            <li><strong>Cập nhật vào lúc:</strong> <span>{{ \Carbon\Carbon::parse($data['updated_at'])->format('Y-m-d H:i:s') }}</span></li>
        </ul>
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
        <div class="footer">
            <p>&copy; 2024 Công ty của bạn. Mọi quyền được bảo lưu.</p>
            <p>Cần hỗ trợ? <a href="mailto:support@yourcompany.com">Liên hệ hỗ trợ</a></p>
        </div>
    </div>
</body>

</html>
