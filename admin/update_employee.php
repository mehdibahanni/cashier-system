<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استرداد البيانات من النموذج
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $employee_password = $_POST['employee_password'];
    $account_status = $_POST['account_status'];


    $hashed_password = password_hash($employee_password, PASSWORD_DEFAULT);

    // استعلام التحديث
    $query = "UPDATE employees SET name = ?, password = ?, account_status = ? WHERE id = ?";
    
    // تنفيذ الاستعلام
    // تأكد من استخدام طريقة الإعداد المسبق (prepared statement) لحماية البيانات
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssi", $employee_name, $hashed_password, $account_status, $employee_id);
    
    if ($stmt->execute()) {
        // نجاح التحديث
        header('Location: manage_employees.php?success=1');
        exit();
    } else {
        // خطأ في التحديث
        header('Location: manage_employees.php?error=1');
        exit();
    }
}

