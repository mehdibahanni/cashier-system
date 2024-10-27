<?php
session_start();
require_once '../connect.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: ./dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                echo  "hallow";
                $_SESSION['admin_logged_in'] = true;
                header('Location: ./dashboard.php');
                exit;
            } else {
                $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
            }
        } else {
            $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
        $stmt->close();
    } else {
        $error_message = "الرجاء ملء جميع الحقول.";
    }
}
mysqli_close($conn);
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