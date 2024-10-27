<?php
require_once '../connect.php';
function closeEmployeeAccounts() {
    global $conn;

    $query = "
        SELECT e.id, e.username, SUM(o.total_price) AS total_sales
        FROM employees e
        LEFT JOIN orders o ON e.id = o.employee_id
        WHERE DATE(o.order_time) = CURDATE()  -- طلبات اليوم فقط
        GROUP BY e.id, e.username
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<div class="container mt-5">';
        echo '<h2 class="text-center mb-4">ملخص مبيعات الموظفين لليوم</h2>';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="thead-light">';
        echo '<tr>';
        echo '<th>رقم الموظف</th>';
        echo '<th>اسم الموظف</th>';
        echo '<th>إجمالي المبيعات (MAD)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['total_sales'] . ' MAD</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5"><div class="alert alert-danger" role="alert">';
        echo "خطأ: " . mysqli_error($conn);
        echo '</div></div>';
    }

    mysqli_close($conn);
}

closeEmployeeAccounts();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملخص مبيعات الموظفين</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
