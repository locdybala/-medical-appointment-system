<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liên hệ từ website</title>
</head>
<body>
    <h2>Thông tin liên hệ mới</h2>

    <p><strong>Họ và tên:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
    <p><strong>Tiêu đề:</strong> {{ $data['subject'] }}</p>
    <p><strong>Nội dung:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>
