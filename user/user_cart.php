<?php
session_start();

// Check if the user is logged in and has the 'user' role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}

include '../config.php';
include '../sidebar.php';

$userId = $_SESSION['user_id'];

// Prepare the SQL statement to get cart items and associated product images
$stmt = $conn->prepare("
    SELECT kb.*, p.image 
    FROM keranjang_belanja kb 
    JOIN products p ON kb.product_id = p.id 
    WHERE kb.user_id = ?
");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the user ID
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600 animate__animated animate__fadeIn">Keranjang Belanja</h1>
        <div id="cart-content" class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border-b text-center align-middle">Gambar Produk</th>
                        <th class="px-4 py-2 border-b text-center align-middle">Nama Produk</th>
                        <th class="px-4 py-2 border-b text-center align-middle">Harga</th>
                        <th class="px-4 py-2 border-b text-center align-middle">Jumlah</th>
                        <th class="px-4 py-2 border-b text-center align-middle">Total</th>
                        <th class="px-4 py-2 border-b text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $productName = htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8');
                            $productPrice = htmlspecialchars($row['product_price'], ENT_QUOTES, 'UTF-8');
                            $quantity = htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8');
                            $subtotal = $productPrice * $quantity;
                            $totalPrice += $subtotal;

                            echo "<tr data-id='" . $row['id'] . "' data-price='" . $productPrice . "' class='hover:bg-gray-100 transition-colors duration-300'>";
                            echo "<td class='px-4 py-2 border-b text-center align-middle'>";
                            $imagePath = '../products/' . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                            echo "<img src='$imagePath' alt='" . htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') . "' class='w-16 h-16 object-cover mx-auto rounded-full'>";
                            echo "</td>";
                                                        echo "<td class='px-4 py-2 border-b text-center align-middle'>" . $productName . "</td>";
                            echo "<td class='px-4 py-2 border-b text-center align-middle'>Rp. " . number_format($productPrice, 0, ',', '.') . "</td>";
                            echo "<td class='px-4 py-2 border-b text-center align-middle'><input type='number' value='" . $quantity . "' class='quantity-input w-16 text-center border rounded'/></td>";
                            echo "<td class='px-4 py-2 border-b text-center align-middle subtotal'>Rp. " . number_format($subtotal, 0, ',', '.') . "</td>";
                            echo "<td class='px-4 py-2 border-b text-center align-middle'>"; 
                            echo '<form action="hapus_dari_keranjang.php" method="POST" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus produk ini?\');">';
                            echo '<input type="hidden" name="id" value="' . htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8') . '">';
                            echo '<button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"><i class="fas fa-trash-alt"></i> Hapus</button>';
                            echo '</form>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='px-4 py-2 border-b text-center'>Keranjang belanja kosong</td></tr>";
                    }
                    echo "<tr><td colspan='4' class='px-4 py-2 border-b font-bold text-right align-middle'>Total</td><td class='px-4 py-2 border-b font-bold text-center align-middle total-price'>Rp. " . number_format($totalPrice, 0, ',', '.') . "</td><td class='px-4 py-2 border-b'></td></tr>";
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center md:text-right">
            <button id="checkoutButton" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 animate__animated animate__pulse">Checkout via WhatsApp</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const row = this.closest('tr');
                const productId = row.dataset.id;
                const productPrice = parseFloat(row.dataset.price);
                const quantity = parseInt(this.value);

                if (quantity < 1) {
                    this.value = 1;
                    return;
                }

                const subtotal = productPrice * quantity;
                row.querySelector('.subtotal').innerText = 'Rp. ' + subtotal.toLocaleString('id-ID');

                updateTotalPrice();

                // Update quantity in the database
                fetch('update_quantity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: quantity
                    })
                });
            });
        });

        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(subtotalElem => {
                total += parseFloat(subtotalElem.innerText.replace('Rp. ', '').replace(/\./g, ''));
            });
            document.querySelector('.total-price').innerText = 'Rp. ' + total.toLocaleString('id-ID');
        }

        async function checkoutWhatsApp() {
            const cartContent = document.getElementById('cart-content');
            const canvas = await html2canvas(cartContent);
            const imgData = canvas.toDataURL('image/png');

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

            const pdfBlob = pdf.output('blob');
            const formData = new FormData();
            formData.append('pdf', pdfBlob, 'keranjang_belanja.pdf');

            try {
                const response = await fetch('upload_pdf.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    const whatsappUrl = `https://wa.me/6281329681232?text=${encodeURIComponent('Halo, saya ingin membeli produk sesuai dengan keranjang belanja saya. Berikut adalah link PDF keranjang belanja saya: ' + result.pdfUrl)}`;
                    window.open(whatsappUrl, '_blank');
                } else {
                    alert('Gagal mengunggah PDF. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        }

        document.getElementById('checkoutButton').addEventListener('click', checkoutWhatsApp);
    </script>
</body>
</html>
