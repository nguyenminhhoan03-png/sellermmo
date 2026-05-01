<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Tiếp Nhận Đơn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #293a53, #28a779);
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .email-body h2 {
            margin-top: 0;
            font-size: 20px;
            color: #007bff;
        }
        .email-body p {
            margin: 0 0 10px;
        }
        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            color: #666666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #293a53, #28a779);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Thông Báo Tiếp Nhận Đơn</h1>
        </div>
        <div class="email-body">
            <h2>Xin chào {{ $user->name }}</h2>
            <p>Chúng tôi đã nhận được đơn của bạn và đang xử lý. Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi!</p>
            <p>Bạn vui lòng chờ thêm thông báo từ chúng tôi để biết kết quả cuối cùng.</p>
            <p>Trân trọng,</p>
            <p>Đội ngũ hỗ trợ</p>
            <a href="{{ route('home') }}" class="btn">Truy cập website</a>
        </div>
        <div class="email-footer">
            <p>&copy; 2024 Your Company. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
