<?php
session_start();
require_once '../connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products");

if (isset($_POST['delete'])) {
    $product_id = $_POST['product_id'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");
    header('Location: manage_products.php');
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
    direction: rtl;
    text-align: right; 
}

.container {
    text-align: right; 
}
</style>
<body>
    <!-- navbar -->
    <?php require('./include/nav.php'); ?>

    <!-- Container -->
    <div class="container">
        <h1 class="mt-5">إدارة المنتجات</h1>
        <a href="add_product.php" class="btn btn-primary mb-3">إضافة منتج</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>الاسم</th>
                    <th>السعر</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['price'] ?> د.م</td>
                        <td><img src="<?= $row['image'] ?>" width="50"></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">تعديل</a>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
