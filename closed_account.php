<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إغلاق الحساب</title>
    <!-- ربط Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* جعل الرسالة في منتصف الصفحة */
        .message-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* تخصيص شكل الرسالة */
        .message-box {
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message-box h1 {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545; /* لون مميز للعنوان */
        }

        .message-box p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="message-container">
        <div class="message-box">
            <h1>تم إغلاق الحساب</h1>
            <p>الحساب مغلق، انتهى دوامك اليوم!</p>
        </div>
    </div>
</div>

<!-- ربط Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
