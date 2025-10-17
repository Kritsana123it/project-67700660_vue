<?php
// เชื่อมต่อฐานข้อมูล
include 'condb.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === "GET") {
        // ✅ ดึงข้อมูลพนักงานทั้งหมด
        $stmt = $conn->prepare("SELECT id, firstname, lastname, username, password, image, created_at, updated_at FROM employee ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["success" => true, "data" => $result]);
    }

    elseif ($method === "DELETE") {
        // ✅ ลบข้อมูลพนักงานตาม id
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า id"]);
            exit;
        }

        $id = intval($data["id"]);

        $stmt = $conn->prepare("DELETE FROM employee WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ลบข้อมูลพนักงานเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Method ไม่ถูกต้อง"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>