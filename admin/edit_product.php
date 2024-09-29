<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

// Pastikan product_id telah diterima dengan benar
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$productId = $_GET['product_id'];

// Ambil detail produk dari database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto max-w-2xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4 animate__animated animate__fadeIn">
            <h2 class="text-3xl font-bold mb-6 text-gray-800 animate__animated animate__fadeInDown">
                <i class="fas fa-edit mr-2 text-blue-500"></i>Edit Product
            </h2>
            <form action="edit_product_process.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                
                <div class="animate__animated animate__fadeInLeft">
                    <label for="name" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-tag mr-2 text-blue-500"></i>Name:
                    </label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" 
                           class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                </div>
                
                <div class="animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
                    <label for="price" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-blue-500"></i>Price:
                    </label>
                    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" 
                           class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                </div>
                
                <div class="animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                    <label for="description" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-500"></i>Description:
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"><?php echo htmlspecialchars($row['description']); ?></textarea>
                </div>

                <div class="animate__animated animate__fadeInLeft" style="animation-delay: 0.3s;">
                    <label for="image" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-image mr-2 text-blue-500"></i>Upload New Image:
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                </div>

                <div class="flex items-center justify-between animate__animated animate__fadeInUp">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <a href="admin_dashboard.php" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-300 transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add subtle hover effect to input fields
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.classList.add('animate__animated', 'animate__pulse');
            });
            input.addEventListener('blur', () => {
                input.classList.remove('animate__animated', 'animate__pulse');
            });
        });
    </script>
</body>
</html>
