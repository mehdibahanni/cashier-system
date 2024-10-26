<?php
session_start();
require_once './connect.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $check_status = "SELECT account_status FROM employees WHERE username='$username'";

    $status = $conn->query($check_status);
    $em_status = $status->fetch_assoc();
    
    if ($em_status['account_status'] == 'closed') {
        header('Location: ./closed_account.php');
        exit();
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM employees WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if ($password === $user['password']) {
                $_SESSION['employe_id'] = $user['id']; 
                $_SESSION['employe_logged_in'] = true;
                header('Location: ./home.php');
                exit;
            } else {
                $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
            }
        } else {
            $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>تسجيل الدخول</title>
    <style>
        body{
            direction: rtl;
            text-align: right;
        }
    </style>
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
                <label for="username">اسم المستخدم:</label>
                <input type="text" class="form-control" id="username" name="username" required>
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