<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

// Pastikan product_id telah diterima dengan benar
if (!isset($_POST['product_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$productId = $_POST['product_id'];
$name = trim($_POST['name']);
$price = trim($_POST['price']);
$description = trim($_POST['description']);

// Validasi input
if (empty($name) || empty($price) || empty($description)) {
    echo "Name, price, and description are required fields.";
    exit();
}

// Memproses upload gambar jika ada
$oldImage = ""; // Variable untuk menyimpan nama gambar lama
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Ambil nama gambar lama dari database
    $sql = "SELECT image FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldImage = $row['image'];
    }

    $targetDir = "../products/"; // Direktori untuk menyimpan gambar
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validasi file gambar
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
        // Upload file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Hapus gambar lama jika ada
            if (!empty($oldImage)) {
                unlink($targetDir . $oldImage); // Hapus file lama
            }

            // Update produk di database dengan gambar baru
            $sql = "UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsi", $name, $price, $description, $fileName, $productId);
            if (!$stmt->execute()) {
                echo "Error updating product: " . $stmt->error;
                exit();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        echo "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF file.";
        exit();
    }
} else {
    // Jika tidak ada gambar baru, hanya update nama, harga, dan deskripsi
    $sql = "UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $name, $price, $description, $productId);
    if (!$stmt->execute()) {
        echo "Error updating product: " . $stmt->error;
        exit();
    }
}

$stmt->close();
$conn->close();

// Redirect kembali ke Admin Dashboard
header("Location: admin_dashboard.php");
exit();
?>
