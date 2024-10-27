<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إغلاق الحساب</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .message-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
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
            color: #dc3545;
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setInterval(function() {
        // const employeeId = "1";
        // const employeeName = "mehdi";

        // // const employeeId = localStorage.getItem('employee_id');
        const employeeName = localStorage.getItem('employe_name');

        $.ajax({
            url: './check_employee_status.php',
            method: 'POST',
            data: {
                name: employeeName
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'open') {
                    window.location.href = './index.php';
                }
            },
            error: function(xhr, status, error) {
                console.error("Error occurred: ", error);
            }
        });
    }, 5000);
</script>
</body>
</html>