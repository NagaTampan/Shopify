<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

// Pastikan product_id telah diterima dengan benar
if (!isset($_POST['product_id'])) {
    echo "Product ID is not provided.";
    exit();
}

$productId = $_POST['product_id'];

// Gunakan prepared statement untuk mencegah SQL Injection
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);

// Eksekusi statement
if ($stmt->execute()) {
    // Redirect kembali ke halaman Admin Dashboard setelah menghapus produk
    header("Location: admin_dashboard.php");
} else {
    // Tampilkan pesan error jika terjadi kesalahan
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
exit();
?>
