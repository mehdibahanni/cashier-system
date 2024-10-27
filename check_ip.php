<?php
$filePath = urldecode($_GET['file']);

$clientIp = $_SERVER['REMOTE_ADDR'];

if ($clientIp === '192.168.1.20') {
    if (file_exists($filePath)) {
        unlink($filePath);
        echo json_encode(['success' => true, 'message' => 'تم حذف الملف.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'لم يتم العثور على الملف.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'IP غير مصرح به.']);
}