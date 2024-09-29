<?php
session_start();

// Security: Check if the user is logged in and has the 'user' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

// Include sidebar and config
include '../sidebar.php';
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <header class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                <i class="fas fa-box-open mr-2 animate__animated animate__bounceIn"></i>
                Product Collection
            </h2>
        </header>
        <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Sanitize output to prevent XSS
                    $productId = htmlspecialchars($row["id"]);
                    $productImage = htmlspecialchars($row["image"]);
                    $productName = htmlspecialchars($row["name"]);
                    $productPrice = htmlspecialchars($row["price"]);

                    echo '<li class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-500 hover:scale-105 animate__animated animate__fadeIn">';
                    echo '<a href="product_detail.php?id=' . $productId . '" class="group block">';
                    echo '<img src="../products/' . $productImage . '" alt="' . $productName . '" class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105" />';
                    echo '<div class="p-4">';
                    echo '<h3 class="text-lg font-semibold text-gray-900 group-hover:underline">' . $productName . '</h3>';
                    echo '<p class="mt-2 text-gray-600">Rp. ' . number_format($productPrice, 0, ',', '.') . '</p>';
                    echo '<button class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">';
                    echo '<i class="fas fa-cart-plus mr-2 animate__animated animate__pulse"></i>Add to Cart';
                    echo '</button>';
                    echo '</div>';
                    echo '</a>';
                    echo '</li>';
                }
            } else {
                echo '<p class="text-center text-gray-600 col-span-full animate__animated animate__fadeIn">No products found</p>';
            }

            $conn->close();
            ?>
        </ul>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
