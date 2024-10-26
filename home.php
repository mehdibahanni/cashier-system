<?php
require './connect.php';
session_start();

if (!isset($_SESSION['employe_logged_in'])) {
    header('Location: ./index.php');
    exit;
}

$id = $_SESSION['employe_id']; 
$check_status = "SELECT account_status FROM employees WHERE id='$id'";

$status = $conn->query($check_status);
$em_status = $status->fetch_assoc();

if ($em_status['account_status'] == 'closed') {
    header('Location: ./closed_account.php');
    exit();
}else{
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام الكاشير</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/styles.css">
    <style>
        body{
            direction: rtl;
            text-align: right;
        }
        body > div.container{
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- alert section -->
    <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="order-alert">
    تم إرسال الطلب للمطبخ!
    </div>

    <!-- section -->
    <?php 
    if(isset($_SESSION['admin_logged_in'])){
        echo '
        <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">رحيه</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/dashboard.php">لوحة التحكم</a>
                </li>
                <li>
                    <a class="nav-link" href="./admin/manage_products.php">إدارة المنتجات</a>
                </li>
                    <a class="nav-link" href="./admin/manage_employees.php">إدارة الموظفين</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/logout.php">تسجيل الخروج</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>';}?>

    <!-- products -->
    <div class="container">
        <h1 class="text-center my-4">نظام الكاشير</h1>
        <div class="row" id="menu">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="./assets/img/big-mac.jpeg" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <p class="card-text"><strong><?= $product['price'] ?> درهم</strong></p>
                            <button class="btn btn-primary add-to-cart" data-id="<?= $product['id'] ?>" data-name="<?= $product['name'] ?>" data-price="<?= $product['price'] ?>">إضافة إلى السلة</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-section">
            <h2>عربة التسوق</h2>
            <ul id="order-list" class="list-group mb-3"></ul>
            <p>المجموع: <span id="total-price">0</span> دينار كويتي</p>
            <button id="submit-order" class="btn btn-success">إرسال الطلب</button>
        </div>
    </div>

    <!-- نافذة لإدخال الكمية -->
    <div class="modal" tabindex="-1" role="dialog" id="quantityModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إدخال الكمية</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="quantity">الكمية:</label>
                    <input type="number" id="quantity" class="form-control" value="1" min="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="save-quantity">إضافة إلى السلة</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./scripts/app.js"></script>
</body>
</html>