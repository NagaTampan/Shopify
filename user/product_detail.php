<?php
session_start();
include '../config.php';

// Cek apakah parameter 'id' ada dan tidak kosong
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: user_dashboard.php");
    exit();
}

$productId = $_GET['id'];

// Gunakan prepared statement untuk mencegah SQL injection
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $productName = $row['name'];
    $productPrice = $row['price'];
    $productDescription = $row['description'];
    $productImage = $row['image'];
    $quantity = 1; // Default quantity
} else {
    // Tampilkan pesan kesalahan jika produk tidak ditemukan
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($productName) ? $productName . ' - Product Detail' : 'Product Detail'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-1/2">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="../products/<?php echo isset($productImage) ? $productImage : ''; ?>" alt="<?php echo isset($productName) ? $productName : ''; ?>" class="w-full h-96 object-cover rounded-lg shadow-md animate__animated animate__fadeIn">
                        </div>
                        <!-- Tambahkan lebih banyak gambar di sini jika ada -->
                    </div>
                    <!-- Tambahkan navigasi slider -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold text-gray-900 mb-4 animate__animated animate__fadeInUp"><?php echo isset($productName) ? $productName : ''; ?></h1>
                <p class="text-xl text-gray-700 mb-6">Rp. <?php echo isset($productPrice) ? number_format($productPrice, 0, ',', '.') : ''; ?></p>
                <p class="text-gray-600 mb-6"><?php echo isset($productDescription) ? nl2br($productDescription) : ''; ?></p>
                <form action="add_to_cart.php" method="POST" class="flex flex-col space-y-4">
                    <input type="hidden" name="product_id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
                    <input type="hidden" name="product_name" value="<?php echo isset($productName) ? $productName : ''; ?>">
                    <input type="hidden" name="product_price" value="<?php echo isset($productPrice) ? $productPrice : ''; ?>">
                    <input type="hidden" name="product_image" value="<?php echo isset($productImage) ? $productImage : ''; ?>">
                    <label for="quantity" class="text-gray-700">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1" class="border rounded px-2 py-1">
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300">
                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                    </button>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Back Button -->
    <a href="javascript:history.back()" class="fixed bottom-10 right-10 bg-yellow-500 text-white px-4 py-2 rounded-full shadow-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounce">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>
</html>
