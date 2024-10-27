<?php
session_start();
require_once '../connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['add'])) {

    // get the variables
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // add the images to the uploads directory if exist and push the path to it in database (perfered)
    $image_paths = [];
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = '../uploads/'; 
        foreach ($_FILES['images']['name'] as $key => $image) {
            $image_tmp_name = $_FILES['images']['tmp_name'][$key];
            $image_ext = pathinfo($image, PATHINFO_EXTENSION); 
            
            $new_image_name = uniqid() . '.' . $image_ext;    
            $image_name = $upload_dir . $new_image_name;
    
            if (move_uploaded_file($image_tmp_name, $image_name)) {
                $image_paths[] = $image_name;
            }
        }
        $images = implode(',', $image_paths);
    } else {
        $images = '/assets/img/big-mac.jpeg';
    }
   
    // add the discrptino if exsit if not add the default
    if (empty($description)) {
        $description = "هذا المنتج هو جزء من قائمة الأطعمة لدينا. تم تحضيره بمكونات عالية الجودة لضمان أفضل تجربة طعام. نحن ملتزمون بتقديم الأطباق التي ترضي جميع الأذواق، ونتمنى أن تستمتع بتجربتك معنا.";
    }
    
    // insert the values to database
    mysqli_query($conn, "INSERT INTO products (name, description, price, quantity, image)
     VALUES ('$name', '$description', '$price', '', '$images')");
    header('Location: manage_products.php');
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
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

    <!-- Container -->
    <div class="container">
        <h1 class="mt-5">إضافة منتج</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">اسم المنتج:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">رابط الصورة:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="description">الوصف (اختياري):</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <button type="submit" name="add" class="btn btn-success">إضافة المنتج</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
