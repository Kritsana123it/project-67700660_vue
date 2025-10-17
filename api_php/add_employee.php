<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// จัดการ preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// เชื่อมต่อฐานข้อมูล
include 'condb.php';

try {
    // ตรวจสอบคำขอที่ได้รับจาก Client ตามประเภทของคำว่าเป็น GET หรือ POST
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method == 'POST') {
        // รับข้อมูลจาก Client
        $data = json_decode(file_get_contents("php://input"), true);

        // ตรวจสอบค่าที่จำเป็น
        if (isset($data['firstname'], $data['lastname'], $data['username'], $data['password'])) {
            // เพิ่มข้อมูลพนักงานใหม่
            $stmt = $conn->prepare("INSERT INTO employee (firstname, lastname, username, password, image) VALUES (:firstname, :lastname, :username, :password, :image)");
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':username', $data['username']);
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
            
            // รองรับการอัพโหลดรูป (ถ้ามี)
            $image = isset($data['image']) ? $data['image'] : null;
            $stmt->bindParam(':image', $image);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "เพิ่มพนักงานสำเร็จ"]);
            } else {
                echo json_encode(["success" => false, "message" => "ไม่สามารถเพิ่มพนักงานได้"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        }
    } 
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>