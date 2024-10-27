<?php
// // إعدادات قاعدة البيانات
// require '../connect.php';


// // البيانات التي تريد إدخالها
// $name = 'mehdi bahanni';
// $email = 'admin@gmail.com';
// $password = 'mehdi2002'; // كلمة المرور الأصلية

// // تشفير كلمة المرور
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// // جملة الإدخال
// $sql = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";

// // إعداد البيان
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("sss", $name, $email, $hashedPassword);

// // تنفيذ البيان
// if ($stmt->execute()) {
//     echo "تم إدخال البيانات بنجاح!";
// } else {
//     echo "خطأ: " . $stmt->error;
// }

// // إغلاق الاتصال
// $stmt->close();
// $conn->close();
$password = "owner";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


echo $hashed_password;

"INSERT INTO admins(name, email, password)VALUES('owner', 'owner@gmail.com', '$2y$10$Pda0WlBvE6e7h54SZTV/SubVaOgaWN46VlY6LRsLh3GlQbSzFNJ1m')";