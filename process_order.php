<?php 
require('./connect.php');
require('./asset/fpdf.php'); // تأكد من استيراد مكتبة FPDF بشكل صحيح

$order = file_get_contents("php://input", true);
$data = json_decode($order, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO orders (employee_id, product_id, product_name, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
    foreach ($data as $item) {
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

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'إيصال الطلب');
    $pdf->Ln(20);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'رقم الطلب: ' . rand(1000, 9999));
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'الوقت: ' . date('Y-m-d H:i:s'));
    $pdf->Ln(10);
    $pdf->Cell(40, 10, '--------------------------------------');
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'الطلبات:');
    $pdf->Ln(10);

    foreach ($data as $index => $order) {
        $sql = "SELECT price FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $order['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $priceData = mysqli_fetch_assoc($result);
        $price = $priceData['price'];

        $totalPrice = $order['quantity'] * $price;
        $pdf->Cell(40, 10, ($index + 1) . ". " . $order['name'] . " - " . $order['quantity'] . " × " . number_format($price, 2) . " دينار كويتي = " . number_format($totalPrice, 2) . " دينار كويتي");
        $pdf->Ln(10);
    }

    $pdf->Cell(40, 10, "الإجمالي: " . number_format($cost, 2) . " دينار");
    $pdf->Ln(10);
    $pdf->Cell(40, 10, '--------------------------------------');
    $pdf->Ln(10);
    $pdf->Cell(40, 10, 'شكراً لتعاملكم معنا!');
    $pdf->Ln(10);

    $filePath = '/pdf/receipt_.pdf';
    $pdf->Output('F', $filePath);

    echo json_encode(['success' => true, 'message' => 'تم إرسال الفاتورة إلى جهاز الطابعة']);
    echo json_encode(['success' => true, 'pdf_url' => 'http://yourserver.com/' . $filePath]);

    header('Location: check_ip.php?file=' . urlencode($filePath));
    exit();

} else {
    echo json_encode(['success' => false, 'message' => 'لا توجد طلبات']);
}
