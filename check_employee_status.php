<?php
session_start();
include './connect.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    $stmt = $conn->prepare("SELECT account_status FROM employees WHERE username=?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $em_status = $result->fetch_assoc();
        echo json_encode(['status' => $em_status['account_status']]);
    } else {
        echo json_encode(['status' => 'error']);
    }
    
} else if (isset($_SESSION['employe_id'])) {
    $id = $_SESSION['employe_id'];

    $stmt = $conn->prepare("SELECT account_status FROM employees WHERE id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $em_status = $result->fetch_assoc();
        echo json_encode(['status' => $em_status['account_status']]);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'not_logged_in']);
}