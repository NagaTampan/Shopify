<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    // Menggunakan __DIR__ untuk mendapatkan jalur absolut dari file ini
    $uploadDir = __DIR__ . '/../uploads/'; // Mengarahkan satu level ke atas untuk folder uploads
    
    // Pastikan direktori upload ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
    }
    
    $fileName = uniqid() . '_keranjang_belanja.pdf';
    $uploadFile = $uploadDir . $fileName;

    // Pindahkan file yang diupload ke direktori tujuan
    if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadFile)) {
        // Buat URL untuk akses file di localhost
        $pdfUrl = 'http://localhost/shopify/uploads/' . $fileName; // Memperbaiki URL
        
        // Mengembalikan respons JSON
        echo json_encode(['success' => true, 'pdfUrl' => $pdfUrl]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
