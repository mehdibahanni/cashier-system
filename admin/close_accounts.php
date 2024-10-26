<?php
// الاتصال بقاعدة البيانات
require_once 'connect.php';

// دالة لحساب مبيعات كل موظف في نهاية اليوم
function closeEmployeeAccounts() {
    global $conn;

    // استعلام لجلب مجموع المبيعات لكل موظف بناءً على الطلبات
    $query = "
        SELECT e.id, e.name, SUM(o.total_price) AS total_sales
        FROM employees e
        LEFT JOIN orders o ON e.id = o.employee_id
        WHERE DATE(o.order_time) = CURDATE()  -- طلبات اليوم فقط
        GROUP BY e.id, e.name
    ";

    // تنفيذ الاستعلام
    $result = mysqli_query($conn, $query);

    if ($result) {
        // طباعة مبيعات كل موظف
        echo "Employee Sales Summary for Today:\n";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Employee ID: " . $row['id'] . "\n";
            echo "Employee Name: " . $row['name'] . "\n";
            echo "Total Sales: " . $row['total_sales'] . " MAD\n";
            echo "--------------------------\n";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // إغلاق اتصال قاعدة البيانات
    mysqli_close($conn);
}

// استدعاء دالة إغلاق الحسابات وحساب المبيعات
closeEmployeeAccounts();

?>
