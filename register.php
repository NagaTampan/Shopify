<?php
// Set secure session settings before starting the session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Start the session
session_start();
include 'config.php';

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

// Implement CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } elseif (strlen($password) < 8) {
        $error = "Password harus memiliki panjang minimal 8 karakter.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Username hanya boleh mengandung huruf, angka, dan underscore.";
    } else {
        // Sanitizing username
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Check if username already exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $error = "Prepare statement gagal: " . $conn->error;
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username sudah digunakan. Silakan pilih username lain.";
            } else {
                // Hash password securely
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $role = 'user'; // Default role

                // Insert new user
                $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $error = "Prepare statement gagal: " . $conn->error;
                } else {
                    $stmt->bind_param("sss", $username, $hashed_password, $role);

                    if ($stmt->execute()) {
                        $success = "Registrasi berhasil. Anda bisa <a href='login.php' class='text-blue-500 hover:text-blue-700'>login</a>.";
                    } else {
                        $error = "Error: " . $stmt->error;
                    }
                }
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .bg-cover {
            background-image: url('image/bg.webp');
            background-size: cover;
            background-position: center;
        }

        /* Custom animations for faster effects */
        .animate-fast {
            animation-duration: 0.5s;
            /* Speed up animations to 0.5 seconds */
        }
    </style>
</head>

<body class="bg-cover h-screen flex justify-center items-center">
    <div
        class="w-full max-w-sm bg-white bg-opacity-90 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4 animate__animated animate__fadeIn animate-fast">
        <h2 class="text-center text-3xl font-bold mb-6 text-gray-800 animate__animated animate__bounceIn animate-fast">
            Register</h2>

        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 animate__animated animate__shakeX animate-fast"
                role="alert">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 animate__animated animate__fadeIn animate-fast"
                role="alert">
                <p><?php echo $success; ?></p>
            </div>
        <?php else: ?>
            <form method="POST" action="" class="animate__animated animate__fadeInUp animate-fast">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        <i class="fas fa-user animate__animated animate__pulse animate__infinite"></i> Username:
                    </label>
                    <input type="text" name="username" id="username" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 transition duration-300">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        <i class="fas fa-lock animate__animated animate__pulse animate__infinite"></i> Password:
                    </label>
                    <input type="password" name="password" id="password" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 transition duration-300">
                    <p class="text-sm text-gray-600">Password harus memiliki minimal 8 karakter.</p>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                        <i class="fas fa-user-plus mr-2"></i> Register
                    </button>
                    <a href="login.php"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
         <!-- Floating Back Button -->
         <a href="index.php" class="fixed bottom-10 right-10 bg-yellow-500 text-white px-4 py-2 rounded-full shadow-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounce">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
</body>

</html>