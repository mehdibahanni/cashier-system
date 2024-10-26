<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
.stat-item {
    background: #ffffff;
    border-radius: 5px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.table {
    background: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}    
body {
    background-color: #f8f9fa;
    direction: rtl;
    text-align: right; 
}
.container {
    text-align: right; 
}
</style>
</head>
<body>

    <!-- navbar -->
    <?php require('./include/nav.php'); ?>

    <!-- content and analysis -->
    <div class="container mt-5">
        <h1 class="text-center">لوحة تحكم</h1>
        
        <!-- قسم الإحصائيات -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="stat-item">
                    <h2>إجمالي المبيعات لليوم</h2>
                    <p>
                        <?php
                        require('../connect.php');
                        // استعلام لجلب إجمالي المبيعات لليوم
                        $today = date('Y-m-d');
                        $sql = "SELECT SUM(total_price) AS total_today FROM orders WHERE DATE(order_time) = '$today'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "$" . number_format($row['total_today'], 2);
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <h2>إجمالي المبيعات للأسبوع</h2>
                    <p>
                        <?php
                        // استعلام لجلب إجمالي المبيعات للأسبوع
                        $sql = "SELECT SUM(total_price) AS total_week FROM orders WHERE WEEK(order_time) = WEEK(NOW())";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "$" . number_format($row['total_week'], 2);
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <h2>إجمالي المبيعات للشهر</h2>
                    <p>
                        <?php
                        // استعلام لجلب إجمالي المبيعات للشهر
                        $sql = "SELECT SUM(total_price) AS total_month FROM orders WHERE MONTH(order_time) = MONTH(NOW()) AND YEAR(order_time) = YEAR(NOW())";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "$" . number_format($row['total_month'], 2);
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- قسم الإحصائيات للعملاء والطلبات -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="stat-item">
                    <h2>عدد العملاء</h2>
                    <p>
                        <?php
                // استعلام لجلب عدد العملاء الفريدين
                $sql = "SELECT COUNT(DISTINCT employee_id) AS total_clients FROM orders GROUP BY DATE_FORMAT(order_time, '%Y-%m-%d %H:%i')";
                $result = $conn->query($sql);
                $total_clients = 0;

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $total_clients++;
                    }
                }
                echo $total_clients;
                ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-item">
                    <h2>عدد الطلبات</h2>
                    <p>
                        <?php
                        // استعلام لجلب عدد الطلبات
                        $sql = "SELECT COUNT(*) AS total_orders FROM orders";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['total_orders'];
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- جدول الطلبات -->
        <h2 class="mt-5">الطلبات</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>معرف الطلب</th>
                    <th>اسم المنتج</th>
                    <th>الكمية</th>
                    <th>السعر الإجمالي</th>
                    <th>وقت الطلب</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // استعلام لجلب الطلبات
                $sql = "SELECT product_id, product_name, quantity, total_price, order_time FROM orders";
                $result = $conn->query($sql);

                // عرض البيانات
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['product_id']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['total_price']}</td>
                                <td>{$row['order_time']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>لا توجد طلبات.</td></tr>";
                }

                // إغلاق الاتصال
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
