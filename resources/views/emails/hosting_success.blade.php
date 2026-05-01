<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin dịch vụ hosting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Kính gửi khách hàng <strong>{{ $user->name }}</strong>,</p>
        <p>Chân thành cảm ơn quý khách đã sử dụng dịch vụ hosting của {{ config('app.name') }}...</p>
        
        <h2>1. Thông tin dịch vụ</h2>
        <table>
            <tr>
                <th>Tên gói hosting</th>
                <td>{{  $hosting->info_package['package_name']  }}</td>
            </tr>
            <tr>
                <th>Tên miền chính</th>
                <td><a href="{{ $hosting->domain_name }}">{{ $hosting->domain_name }}</a></td>
            </tr>
            <tr>
                <th>Chu kỳ thanh toán</th>
                <td>{{ $hosting->month }} tháng</td>
            </tr>
            <tr>
                <th>Số tiền thanh toán</th>
                <td>{{ number_format($hosting->total) }} VND</td>
            </tr>
            <tr>
                <th>Số tiền gia hạn</th>
                <td>{{ number_format($hosting->total) }} VND VND</td>
            </tr>
            <tr>
                <th>Ngày thanh toán kế tiếp</th>
                <td>{{ date('Y-m-d', $hosting->end_date) }}</td>
            </tr>
        </table>
        
        <h2>2. Thông tin đăng nhập</h2>
        <p>Server IP: {{ $hosting->ip }}</p>
        <p>Link đăng nhập vào cPanel: <a href="https://{{ $hosting->server_whm['whm_host'] }}">{{ $hosting->server_whm['whm_host'] }}</a></p>
        <p><strong>Username:</strong> {{ $hosting->username }}</p>
        <p><strong>Password:</strong> {{ $hosting->password }}</p>
        
        <h2>3. Các thông tin khác</h2>
        <p>Server Name: <a href="https://{{ $hosting->server_whm['whm_host'] }}">{{ $hosting->server_whm['whm_host'] }}</a></p>
        <p>Máy chủ FTP: <a href="https://{{ $hosting->domain_name }}">{{ $hosting->domain_name }}</a></p>
        <p>Địa chỉ trang web: <a href="http://{{ $hosting->domain_name }}">http://{{ $hosting->domain_name }}</a></p>
    </div>
</body>
</html>
