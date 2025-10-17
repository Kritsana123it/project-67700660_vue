<?php

// เชื่อมต่อฐานข้อมูล
include 'condb.php';

try {
    // ตรวจสอบคำขอที่ได้รับจาก Client ตามประเภทของคำว่าเป็น GET หรือ POST
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'GET') {
        // ดึงข้อมูลพนักงานทั้งหมด
        $stmt = $conn->prepare("SELECT id, firstname, lastname, username, password, image, created_at, updated_at FROM employee ORDER BY id DESC");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>