<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .order-info h3 {
            margin-top: 0;
            color: #667eea;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item-name {
            flex: 1;
        }
        .order-item-qty {
            width: 80px;
            text-align: center;
        }
        .order-item-price {
            width: 100px;
            text-align: right;
            font-weight: bold;
            color: #e74c3c;
        }
        .order-summary {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        .summary-row.total {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            border-top: 2px solid #bdc3c7;
            padding-top: 10px;
            margin-top: 10px;
        }
        .payment-method {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .payment-method h4 {
            margin-top: 0;
            color: #2980b9;
            font-size: 14px;
        }
        .payment-method p {
            margin: 0;
            font-weight: bold;
            color: #333;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            margin: 20px 0;
            font-weight: bold;
        }
        .note {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 12px;
            border-radius: 6px;
            color: #856404;
            font-size: 14px;
            margin: 20px 0;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✓ Đặt hàng thành công</h1>
            <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                <p>Xin chào <strong>{{ $userName }}</strong>,</p>
                <p>Chúng tôi vui mừng xác nhận rằng đơn hàng của bạn đã được tiếp nhận thành công. Vui lòng xem chi tiết dưới đây:</p>
            </div>

            <!-- Order Items -->
            <div class="order-info">
                <h3>📦 Chi tiết sản phẩm</h3>
                @foreach($cartItems as $id => $item)
                    <div class="order-item">
                        <div class="order-item-name">
                            {{ $item['name'] }}
                        </div>
                        <div class="order-item-qty">
                            x{{ $item['quantity'] }}
                        </div>
                        <div class="order-item-price">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-row">
                    <span>Tổng tiền hàng:</span>
                    <span>{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="payment-method">
                <h4>💳 Hình thức thanh toán</h4>
                <p>
                    @switch($paymentMethod)
                        @case('tien_mat')
                            💵 Tiền mặt
                            @break
                        @case('chuyen_khoan')
                            🏦 Chuyển khoản
                            @break
                        @case('the_tin_dung')
                            💳 Thẻ tín dụng
                            @break
                        @default
                            {{ $paymentMethod }}
                    @endswitch
                </p>
            </div>

            <div class="note">
                <strong>📝 Lưu ý quan trọng:</strong> Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận thông tin giao hàng và thời gian nhận hàng.
            </div>

            <div class="divider"></div>

            <!-- Contact Info -->
            <div style="background-color: #f9f9f9; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <h4 style="margin-top: 0; color: #333;">📧 Thông tin liên hệ</h4>
                <p style="margin: 8px 0;">
                    <strong>Email:</strong> {{ $userEmail }}<br>
                    <strong>Chúng tôi:</strong> kiennv_htttql@hub.edu.vn<br>
                    <strong>Hotline:</strong> 0123 456 789
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 10px 0;">© {{ date('Y') }} Cửa hàng bán Laptop. All rights reserved.</p>
            <p style="margin: 5px 0; color: #999;">Đây là email tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
