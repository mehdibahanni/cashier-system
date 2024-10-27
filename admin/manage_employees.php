<?php
session_start();
require_once '../connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ./index.php');
    exit;
}
$result = mysqli_query($conn, "SELECT * FROM employees");


    // add an employee
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $account_status = $_POST['account_status'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO employees (username, password, account_status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username,  $hashed_password, $account_status);

    if ($stmt->execute()) {
        echo "<script>alert('تم إضافة الموظف بنجاح!');</script>";
        header('Location: ./manage_employees.php');
    } else {
        echo "<script>alert('حدث خطأ أثناء إضافة الموظف.');</script>";
    }
    $stmt->close(); 
}

    // delete employee
if (isset($_POST['delete'])) {
    $employee_id = $_POST['employee_id'];
    mysqli_query($conn, "DELETE FROM employees WHERE id = $employee_id");
    header('Location: manage_employees.php');
}

    // edite employee
// if (isset($_POST['edit'])) {
//     $employee_id = $_POST['employee_id'];

//     if (isset($employee_id) && !empty($employee_id)) {
//         $query = "SELECT name, password, account_status FROM employees WHERE id = ?";
        
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("i", $employee_id);
        
//         $stmt->execute();
//         $result = $stmt->get_result();
        
//         if ($employee = $result->fetch_assoc()) {
//             $employee_name = $employee['name'];
//             $employee_status = $employee['account_status'];
//             $employee_password = $employee['password'];

//             echo "
//                 <script>
//                     $(document).ready(function(){
//                         $('#editEmployeeModal').modal('show');
//                         $('#employee_name').val('$employee_name');
//                         $('#employee_password').val('$employee_password');
//                         $('#employee_status').val('$employee_status');
//                     });
//                 </script>
//             ";
//         } else {
//             echo "<script>alert('لا يوجد موظف بهذا المعرف.');</script>";
//         }
//     } else {
//         echo "<script>alert('معرف الموظف غير صالح.');</script>";
//     }
// }

// close the employees account automatical
if(isset($_POST['close_employees_accounts'])){
    $sql = "UPDATE employees SET account_status = 'close' WHERE account_status = 'open'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>('تم إغلاق جميع حسابات الموظفين بنجاح.')</script>";
        header('Location: ./manage_employees.php');
    } else {
        echo "<script>('حدث خطأ أثناء إغلاق الحسابات: '".$conn->error."')</script>";
    }
}
// open the employees account automatical
if(isset($_POST['open_employees_accounts'])){
    $sql = "UPDATE employees SET account_status = 'open' WHERE account_status = 'close'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>('تم فتح جميع حسابات الموظفين بنجاح.')</script>";
        header('Location: manage_employees.php');
    } else {
        echo "<script>('حدث خطأ أثناء فتح الحسابات: '".$conn->error."')</script>";
    }
}

$alert_message = '';
$alert_type = '';

if (isset($_POST['close_account'])) {
    $employee_id = $_POST['employee_id'];
    $update_status = mysqli_query($conn, "UPDATE employees SET account_status = 'close' WHERE id = '$employee_id'");

    if ($update_status) {        
        $alert_message = "تم إغلاق حساب الموظف بنجاح.";
        $alert_type = "success";
        header("Location: ./manage_employees.php");
        exit;

    } else {
        $alert_message = "حدث خطأ أثناء إغلاق الحساب.";
        $alert_type = "danger";
    }
}

// close employee id
if (isset($_POST['open_account'])) {
    $employee_id = $_POST['employee_id'];

    $update_status = mysqli_query($conn, "UPDATE employees SET account_status = 'open' WHERE id = '$employee_id'");

    if ($update_status) {
        $alert_message = "تم فتح الحساب بنجاح.";
        $alert_type = "success";
        header("Location: ./manage_employees.php");
    } else {
        $alert_message = "حدث خطأ أثناء فتح الحساب.";
        $alert_type = "danger";
    }
    header('Location: ./manage_employees.php');
}


?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الموظفين</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    <!-- navar -->
    <?php require('./include/nav.php'); ?>

    <!-- alert section -->
    <?php if ($alert_message): ?>
        <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
            <?= $alert_message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- modal for add employee -->
    <div class="container mt-5">
        <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEmployeeModalLabel">إضافة موظف جديد</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="./manage_employees.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="أدخل اسم المستخدم" required>
                            </div>
                            <div class="form-group">
                                <label for="password">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                            </div>
                            <div class="form-group">
                                <label for="account_status">حالة الحساب</label>
                                <select class="form-control" id="account_status" name="account_status">
                                    <option value="open" selected>مفتوح</option>
                                    <option value="close">مغلق</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button name="add" id="add" type="submit" class="btn btn-primary">إضافة الموظف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for edite employees -->
    <div class="modal fade" id="editEmployeeModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel<?=$row['id']?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel<?=$row['id']?>">تعديل الموظف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="manage_employees.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?=$row['id']?>">
                        <div class="form-group">
                            <label for="employeeName<?=$row['id']?>">اسم الموظف</label>
                            <input type="text" class="form-control" id="employeeName<?=$row['id']?>" name="employee_name" value="<?=$row['name']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="employeePosition<?=$row['id']?>">المسمى الوظيفي</label>
                            <input type="text" class="form-control" id="employeePosition<?=$row['id']?>" name="employee_position" value="<?=$row['position']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="employeeEmail<?=$row['id']?>">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="employeeEmail<?=$row['id']?>" name="employee_email" value="<?=$row['email']?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5">إدارة الموظفين</h1>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addEmployeeModal">إضافة موظف</a>        
        <form action="./manage_employees.php" method="POST">
        <button name="close_employees_accounts" class="btn btn-secondary mb-3">إغلاق حساب الموظفين</button>
        <button name="open_employees_accounts" class="btn btn-secondary mb-3">فتح حساب الموظفين</button>
        </form>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['account_status'] ?></td>
                        <td>
                            <!-- edite em button -->
                            <!-- <form action="manage_employees.php" style="display:inline;">
                                <input type="hidden" name="employee_id" value="<?=$row['id']?>">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editEmployeeModal<?=$row['id']?>">
                                    تعديل
                                </button>
                            </form> -->
                            <div>
                                <a href="./edite.php?<?=$row['id']?>" name="employee_id" class="btn btn-warning btn-sm"></a>
                            </div>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="employee_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="employee_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="close_account" class="btn btn-secondary btn-sm">إغلاق الحساب</button>
                            </form>

                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="employee_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="open_account" class="btn btn-secondary btn-sm">فتح الحساب</button>
                            </form>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="../script/manage_employees.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>