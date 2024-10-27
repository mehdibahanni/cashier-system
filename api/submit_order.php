<?php
// الاتصال بقاعدة البيانات
require_once '../connect.php';  // التأكد من وجود ملف الاتصال بقاعدة البيانات

// التحقق من أن الطلب جاء باستخدام POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استلام البيانات المرسلة من التابلت
    $employee_id = $_POST['employee_id'];
    $order_items = $_POST['order_items'];  // يجب أن يكون هذا عبارة عن قائمة JSON للمنتجات المطلوبة
    $total_price = $_POST['total_price'];
    
    // التحقق من البيانات الأساسية
    if (empty($employee_id) || empty($order_items) || empty($total_price)) {
        echo json_encode(['status' => 'error', 'message' => 'Incomplete order data.']);
        exit;
    }

    // تحويل قائمة العناصر من JSON إلى مصفوفة
    $order_items_array = json_decode($order_items, true);

    // التحقق من أن التحويل تم بنجاح
    if (!is_array($order_items_array)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid order items format.']);
        exit;
    }

    // إدخال الطلب في جدول الطلبات
    $insert_order_query = "INSERT INTO orders (employee_id, total_price, order_time) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $insert_order_query);
    mysqli_stmt_bind_param($stmt, 'id', $employee_id, $total_price);

    if (mysqli_stmt_execute($stmt)) {
        // الحصول على ID الطلب الجديد
        $order_id = mysqli_insert_id($conn);

        // إدخال كل عنصر من عناصر الطلب في جدول order_items
        foreach ($order_items_array as $item) {
            $item_name = $item['name'];
            $item_price = $item['price'];
            $item_quantity = $item['quantity'];

            $insert_item_query = "INSERT INTO order_items (order_id, item_name, item_price, quantity) VALUES (?, ?, ?, ?)";
            $stmt_item = mysqli_prepare($conn, $insert_item_query);
            mysqli_stmt_bind_param($stmt_item, 'isdi', $order_id, $item_name, $item_price, $item_quantity);
            mysqli_stmt_execute($stmt_item);
        }

        // إرسال استجابة نجاح
        echo json_encode(['status' => 'success', 'message' => 'Order submitted successfully.']);
    } else {
        // إرسال استجابة خطأ
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit order.']);
    }
} else {
    // إذا كانت الطريقة ليست POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

// إغلاق الاتصال بقاعدة البيانات
mysqli_close($conn);