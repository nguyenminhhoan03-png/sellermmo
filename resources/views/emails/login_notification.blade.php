<!DOCTYPE html>
<html>
<head>
    <title>Thông báo đăng nhập vào tài khoản</title>
</head>
<body>
    <h1>Xin chào {{ $user->name }},</h1>
    <p>Chúng tôi phát hiện một lần đăng nhập mới vào tài khoản của bạn vào lúc {{ now() }}.</p>
    
    <p><strong>Thông tin đăng nhập:</strong></p>
    <ul>
        <li><strong>Thời gian:</strong> {{ now() }}</li>
        <li><strong>Địa chỉ IP:</strong> {{ request()->ip() }}</li>
        <li><strong>Thiết bị:</strong> {{ request()->userAgent(), }}</li>
    </ul>

    <p>Nếu bạn vừa thực hiện hành động này, không cần làm gì thêm.</p>
    
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ hỗ trợ {{ config('app.name') }}</strong></p>
</body>
</html>
