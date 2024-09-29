<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        function showAlert() {
            alert("Product has been deleted.");
        }
    </script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-lg">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://www.instagram.com/eagleschool_/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="../image/logo.png" class="h-8 animate__animated animate__fadeIn" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white animate__animated animate__fadeIn">Admin Dashboard</span>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition-transform duration-300 hover:scale-110" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="/api/placeholder/32/32" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 animate__animated animate__fadeIn" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white"><?php echo $_SESSION['username']; ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors duration-200"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors duration-200"><i class="fas fa-cog mr-2"></i>Settings</a>
                        </li>
                        <li>
                            <a href="../logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white transition-colors duration-200"><i class="fas fa-sign-out-alt mr-2"></i>Sign out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 animate__animated animate__fadeInDown">Product Management</h1>
        
        <a href="add_product.php" class="group relative inline-block text-sm font-medium text-white focus:outline-none focus:ring mb-6 animate__animated animate__fadeInLeft">
            <span class="absolute inset-0 border border-green-600 group-active:border-green-500"></span>
            <span class="block border border-green-600 bg-green-600 px-12 py-3 transition-transform active:border-green-500 active:bg-green-500 group-hover:-translate-x-1 group-hover:-translate-y-1">
                <i class="fas fa-plus-circle mr-2"></i> Add New Product
            </span>
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-hidden animate__animated animate__fadeInUp">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php
                    $sql = "SELECT * FROM products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-50 transition-colors duration-200'>";
                            echo '<td class="px-6 py-4 whitespace-nowrap"><img src="../products/' . $row["image"] . '" alt="' . $row["name"] . '" class="h-16 w-16 object-cover rounded-full" /></td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">' . $row["name"] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">Rp.' . $row["price"] . '</td>';
                            echo '<td class="px-6 py-4 whitespace-nowrap">';
                            echo '<div class="flex space-x-2">';
                            echo '<form action="delete_product.php" method="POST">';
                            echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                            echo '<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors duration-200" onclick="showAlert()"><i class="fas fa-trash-alt mr-2"></i>Delete</button>';
                            echo '</form>';
                            echo '<form action="edit_product.php" method="GET">';
                            echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                            echo '<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-200"><i class="fas fa-edit mr-2"></i>Edit</button>';
                            echo '</form>';
                            echo '</div>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-6 py-4 text-center'>No products found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Add hover animation to buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.classList.add('animate__animated', 'animate__pulse');
            });
            button.addEventListener('animationend', () => {
                button.classList.remove('animate__animated', 'animate__pulse');
            });
        });
    </script>
</body>
</html>