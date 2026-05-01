<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Thanh Toán Thành Công</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f7fa;
        }
        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 40px;
            background: linear-gradient(135deg, #293a53, #28a779);
            color: #fff;
        }
        .header img {
            width: 70px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .content h2 {
            color: #28a745;
            font-size: 22px;
            margin-bottom: 15px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }
        .order-summary {
            margin: 25px 0;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-summary td {
            padding: 10px 0;
            font-size: 16px;
        }
        .order-summary .total {
            font-weight: bold;
            color: #28a745;
            font-size: 18px;
        }
        .download-button {
            text-align: center;
            margin: 30px 0;
        }
        .download-button a {
            display: inline-block;
            background-color: #ff0900;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .download-button a:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            padding: 25px;
            background-color: #f4f6f9;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://imgur.com/4qFCM0E.png" alt="Thanh toán thành công">
            <h1>Thanh Toán Thành Công</h1>
        </div>
        <div class="content">
            <h2>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</h2>
            <p>Chúng tôi rất vui được thông báo rằng bạn đã thanh toán thành công. Vui lòng kiểm tra chi tiết hóa đơn dưới đây.</p>
            <div class="order-summary">
                <table>
                    <tr>
                        <td>Tên miền:</td>
                        <td style="text-align: right;">{{ $domainame }}</td>
                    </tr>
                    <tr>
                        <td>Số tiền:</td>
                        <td style="text-align: right;">{{ number_format($giagoc) }}đ</td>
                    </tr>
                    <tr>
                        <td>Chiết Khấu:</td>
                        <td style="text-align: right;">{{ $ck }}%</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid #ddd;"></td>
                    </tr>
                     <tr>
                        <td>Trạng thái miền:</td>
                        <td style="text-align: right; color:green;">Đang xử lý</td>
                    </tr>
                    <tr>
                        <td>Tổng cộng:</td>
                        <td style="text-align: right;" class="total">{{ number_format($value) }}đ</td>
                    </tr>
                </table>
            </div>
            <div class="download-button">
                <a href="{{ route('home') }}">Quay Lại</a>
            </div>
        </div>
        <div class="footer">
            <p>Mọi thắc mắc vui lòng liên hệ:</p>
            <p>Hotline: <a href="tel:+84978009289">+84 978 009 289</a><br>
            Email: <a href="mailto:contact@muabanwebsite.io.vn">contact@muabanwebsite.io.vn</a>
        </div>
    </div>
</body>
</html>
