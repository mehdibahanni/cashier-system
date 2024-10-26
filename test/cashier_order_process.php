

################################""
// // استقبال البيانات من الطلب
// $data = json_decode(file_get_contents("php://input"), true);

// if ($data && isset($data['orders'])) {
//     $stmt = $conn->prepare("INSERT INTO orders (employee_id, product_id, product_name, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
    
//     if ($stmt === false) {
//         echo json_encode(['success' => false, 'message' => 'فشل إعداد الاستعلام']);
//         exit;
//     }

//     foreach ($data['orders'] as $order) {
//         $id = $order['id'];
//         $name = $order['name'];
//         $quantity = $order['quantity'];
//         $cost = $order['cost'];
//         $employee_id = '1';

//         // ربط المتغيرات مع الاستعلام
//         $stmt->bind_param("iissd", $employee_id, $id, $name, $quantity, $cost);
        
//         // تنفيذ الاستعلام
//         if (!$stmt->execute()) {
//             echo json_encode(['success' => false, 'message' => 'فشل إدخال الطلب']);
//             exit;
//         }
//     }
//     $stmt->close();


//     echo json_encode(['success' => true]);
// } else {
//     // رد بالخطأ إذا لم يتم العثور على الطلبات
//     echo json_encode(['success' => false, 'message' => 'لا توجد طلبات']);
// }

####################################


// print the order on cashier

// $orders = $data['orders'];

// // تجهيز الإيصال
// $receipt = "--------------------------------------\n";
// $receipt .= "         رحيه   \n";
// $receipt .= "--------------------------------------\n";
// $receipt .= "رقم الطلب: " . rand(1000, 9999) . "\n";
// $receipt .= "الوقت: " . date('Y-m-d H:i:s') . "\n\n";
// $receipt .= "الطلبات:\n";

// // إضافة الطلبات
// foreach ($orders as $order) {
//     $receipt .= $order['name'] . "    " . $order['quantity'] . " × " . $order['cost'] . " دينار\n";
// }

// $receipt .= "--------------------------------------\n";
// $receipt .= "الإجمالي: " . array_sum(array_column($orders, 'cost')) . " دينار\n";
// $receipt .= "--------------------------------------\n";
// $receipt .= "حياكم الله، شكراً لتعاملكم معانا!\n";
// $receipt .= "--------------------------------------\n";

// // إرسال إلى الطابعة أو تخزين الإيصال
// file_put_contents('receipts.txt', $receipt, FILE_APPEND);

// رد بالإيجابية عند نجاح العملية

###############################################
// submit_order.php
// include 'connect.php';

// $employee = $_POST['employee'];
// $order_items = json_decode($_POST['order_items']);
// $total_price = $_POST['total_price'];

// // Insert order into database
// $sql = "INSERT INTO orders (employee, total_price) VALUES ('$employee', '$total_price')";

// if ($conn->query($sql) === TRUE) {
//     $order_id = $conn->insert_id;
//     foreach ($order_items as $item) {
//         $item_name = $item->name;
//         $item_price = $item->price;
//         $conn->query("INSERT INTO order_items (order_id, item_name, item_price) VALUES ('$order_id', '$item_name', '$item_price')");
//     }
//     echo "Order submitted successfully!";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $conn->close();