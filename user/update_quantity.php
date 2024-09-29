<?php
include '../config.php';
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['quantity'])) {
    $id = $data['id'];
    $quantity = $data['quantity'];

    $sql = "UPDATE keranjang_belanja SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    $stmt->close();
}
$conn->close();
?>
