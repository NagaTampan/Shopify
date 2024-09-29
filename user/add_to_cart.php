<?php
session_start();
require_once('../config.php');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login untuk menambahkan produk ke keranjang.");
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$product_price = $_POST['product_price'] ?? '';
$quantity = $_POST['quantity'] ?? '';

// Validasi data
if (!is_numeric($product_id) || !is_numeric($product_price) || !is_numeric($quantity)) {
    die("Data produk tidak valid.");
}

$product_id = intval($product_id);
$product_price = floatval($product_price);
$quantity = intval($quantity);

if ($quantity < 1) {
    die("Jumlah produk tidak valid.");
}

$product_name = htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');

// Gunakan prepared statements untuk memasukkan data ke dalam database
$stmt = $conn->prepare("INSERT INTO keranjang_belanja (user_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE quantity = quantity + ?");
$stmt->bind_param("iisdis", $user_id, $product_id, $product_name, $product_price, $quantity, $quantity);

// Eksekusi statement
if ($stmt->execute()) {
    // Redirect kembali ke halaman sebelumnya atau halaman tertentu
    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? 'default_page.php'; // Ganti 'default_page.php' dengan halaman yang sesuai
    header('Location: ' . $redirectUrl);
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
