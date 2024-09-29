<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Hapus produk dari keranjang berdasarkan ID
        $sql = "DELETE FROM keranjang_belanja WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Redirect kembali ke halaman keranjang_belanja.php setelah menghapus produk
            header("Location: user_cart.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
