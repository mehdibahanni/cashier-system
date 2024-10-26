<?php

require('./connect.php');

$order = file_get_contents("php://input", true);
$data = json_decode($order, true);

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $stmt = $conn->prepare("INSERT INTO orders (employee_id, product_id, product_name, quantity, total_price) VALUES (?, ?, ?, ?, ?)");

    foreach($data as $item){
        $id = $item['id'];
        $name = $item['name'];
        $quantity = $item['quantity'];
        $cost = $item['cost'];
        $employee_id = 1;

        $stmt->bind_param("iissd", $employee_id, $id, $name, $quantity, $cost);
        
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'فشل إدخال الطلب']);
            exit;
        }
    }

// تجهيز الإيصال
$receipt = "--------------------------------------\n";
$receipt .= "         رحيه   \n";
$receipt .= "--------------------------------------\n";
$receipt .= "رقم الطلب: " . rand(1000, 9999) . "\n";
$receipt .= "الوقت: " . date('Y-m-d H:i:s') . "\n\n";
$receipt .= "الطلبات:\n";

// إضافة الطلبات
foreach ($data as $index => $order) { 
    $sql = "SELECT price FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $priceData = mysqli_fetch_assoc($result);
    $price = $priceData['price']; // سعر المنتج

    $totalPrice = $order['quantity'] * $price;
    $receipt .= ($index + 1) . ". " . $order['name'] . "    " . $order['quantity'] . " × " . number_format($price, 2) . " دينار كويتي = " . number_format($totalPrice, 2) . " دينار كويتي\n";
}
$receipt .= "--------------------------------------\n";
$receipt .= "الإجمالي: " . $order['cost'] . " دينار\n";
$receipt .= "--------------------------------------\n";
$receipt .= "حياكم الله، شكراً لتعاملكم معانا!\n";
$receipt .= "--------------------------------------\n";

// إرسال إلى الطابعة أو تخزين الإيصال
file_put_contents('receipts.txt', $receipt, FILE_APPEND);

//     $cashier_ip = '192.168.1.50';
//     $url = "http://$cashier_ip/receive_invoice.php";

//     // إرسال البيانات باستخدام POST
//     $data = ['receipt' => $receipt];
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//     $response = curl_exec($ch);
//     curl_close($ch);


//     echo "تم إرسال الفاتورة إلى الكاشير.";

    $stmt->close();    
    echo json_encode(['success' => true]);
}else{
    echo json_encode(['success' => false, 'message' => 'لا توجد طلبات']);
}