<?php
// معلومات الاتصال بقاعدة البيانات
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cashier_system';

// إنشاء اتصال بقاعدة البيانات
$conn = mysqli_connect($host, $user, $password, $database);

// التحقق من الاتصال
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

