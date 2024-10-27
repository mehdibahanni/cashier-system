<?php
session_start();
require_once './connect.php';

if (isset($_SESSION['employe_logged_in']) || isset($_SESSION['admin_logged_in'])) {
    header('Location: ./home.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];

    $result = mysqli_query($conn, "SELECT * FROM employees WHERE username='$username'");
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if($row['account_status'] === 'close'){
            header('Location: ./closed_account.php');
        }else{
            $id = $row['id'];
            $name = $row['username'];
            // echo 
            // "<script>
            //     localStorage.setItem('employe_id', '$id');
            //     localStorage.setItem('employe_name', '$name');
            // </script>";
            
            $_SESSION['employe_logged_in'] = true; 
            $_SESSION['employe_id'] = $id; 
            header('Location: ./home.php'); 
            exit();
        }
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
            <button type="submit" name="login" class="btn btn-primary btn-block">تسجيل الدخول</button>
        </form>
    </div>
    <script>
        document.querySelector('button').addEventListener('click', ()=>{
        const employeID = document.querySelector('#username').value
        localStorage.setItem('employe_name', employeID);
        })
    </script>
</body>
</html>