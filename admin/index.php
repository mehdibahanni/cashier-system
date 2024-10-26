<?php
session_start();
require_once '../connect.php'; // تأكد من أن لديك ملف اتصال بالقاعدة البيانات

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // استعلام للتحقق من بيانات الاعتماد

    $result = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' AND password='$password'");
    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true; // تعيين جلسة المستخدم كمدير
        header('Location: ./dashboard.php'); // إعادة التوجيه إلى لوحة التحكم
        exit;
    } else {
        $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">تسجيل الدخول</h1>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?= $error_message ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="mt-3">
            <div class="form-group">
                <label for="email">اسم المستخدم:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>
