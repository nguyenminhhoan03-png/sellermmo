<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo: Tên miền đã được phê duyệt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background: linear-gradient(to bottom, #ffffff, #f9f9f9);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e6e6e6;
        }
        .email-header {
            background-color: #4caf50;
            color: #ffffff;
            text-align: center;
            padding: 20px 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .email-body {
            padding: 20px 30px;
            color: #333333;
            line-height: 1.8;
        }
        .email-body p {
            margin: 10px 0;
            font-size: 16px;
        }
        .email-body .details {
            background-color: #f7fdf7;
            border-left: 5px solid #4caf50;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .email-body .details ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .email-body .details ul li {
            font-size: 15px;
            margin: 8px 0;
        }
        .cta-button {
            text-align: center;
            margin-top: 20px;
        }
        .cta-button a {
            display: inline-block;
            background: linear-gradient(to right, #4caf50, #66bb6a);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .cta-button a:hover {
            background: linear-gradient(to right, #43a047, #5aa462);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .email-footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px 20px;
            font-size: 14px;
            color: #777777;
            border-top: 1px solid #e6e6e6;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .email-footer a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Tên miền đã được phê duyệt</h1>
        </div>
        <!-- Body -->
        <div class="email-body">
            <p>Chào <strong>{{ $user->name }}</strong>,</p>
            <p>Chúng tôi rất vui mừng thông báo rằng tên miền của bạn, <strong>{{ $domainame }}</strong>, đã được phê duyệt thành công và sẵn sàng hoạt động.</p>

            <div class="details">
                <p><strong>Chi tiết tên miền:</strong></p>
                <ul>
                    <li><strong>Tên miền:</strong> {{ $domainame }}</li>
                    <li><strong>Ngày phê duyệt:</strong> {{ gettime() }}</li>
                    <li><strong>Thời gian hiệu lực:</strong> {{ gettime() }}</li>
                </ul>
            </div>

            <p>Để quản lý và sử dụng tên miền, vui lòng truy cập vào hệ thống của chúng tôi thông qua liên kết dưới đây:</p>

            <div class="cta-button">
                <a href="{{ route('domain.history') }}">Quản lý Tên miền</a>
            </div>

            <p>Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ qua:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:{{ setting('email', 'email@local.com') }}">{{ setting('email', 'email@local.com') }}</a></li>
                <li><strong>Hotline:</strong> {{ setting('sdt', '19006789') }}</li>
            </ul>

            <p>Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>
        </div>
        <!-- Footer -->
        <div class="email-footer">
            <p>Trân trọng,<br>Kính Gửi - {{ $user->name }}</p>
            <p>{{ setting('footer_text', 'DVR') }} | <a href="{{ route('home') }}">{{ setting('title', 'DVR') }}</a></p>
        </div>
    </div>
</body>
</html>
