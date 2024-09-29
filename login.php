<?php
// Set secure session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

session_start(); // Start the session

// Include configuration file
include 'config.php';

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Implement CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    // Sanitize input and validate
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } elseif (strlen($username) < 3 || strlen($password) < 6) {
        $error = "Username must be at least 3 characters and password at least 6 characters.";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $sql = "SELECT * FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    // Store user information in session
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $row['role'];

                    // Implement secure cookie
                    $cookie_name = "user";
                    $cookie_value = hash('sha256', $username . $_SERVER['REMOTE_ADDR']);
                    setcookie($cookie_name, $cookie_value, [
                        'expires' => time() + (86400 * 30), // 30 days
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'Strict'
                    ]);

                    // Reset login attempts on successful login
                    unset($_SESSION['login_attempts']);

                    // Redirect based on user role
                    header("Location: " . ($row['role'] === 'admin' ? "admin/admin_dashboard.php" : "user/user_dashboard.php"));
                    exit();
                } else {
                    $error = "Invalid username or password.";
                    incrementLoginAttempts();
                }
            } else {
                $error = "Invalid username or password.";
            }

            $stmt->close();
        }
    }
}

// Function to increment login attempts
function incrementLoginAttempts() {
    $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
    if ($_SESSION['login_attempts'] >= 5) {
        echo "<script>alert('Too many failed attempts. Please try again later.');</script>";
        // You may implement a cooldown period or lockout here
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .bg-cover {
            background-image: url('image/bg.webp');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-cover h-screen flex justify-center items-center">
    <div class="w-full max-w-sm bg-white bg-opacity-75 shadow-md rounded px-8 pt-6 pb-8 mb-4 animate__animated animate__fadeIn">
        <h2 class="text-center text-2xl font-bold mb-4 animate__animated animate__bounceIn">Login</h2>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate__animated animate__shakeX" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-user animate__animated animate__pulse animate__infinite"></i> Username:
                </label>
                <input type="text" name="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-lock animate__animated animate__pulse animate__infinite"></i> Password:
                </label>
                <input type="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
                <a href="register.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </a>
            </div>
        </form>
    </div>
     <!-- Floating Back Button -->
     <a href="index.php" class="fixed bottom-10 right-10 bg-yellow-500 text-white px-4 py-2 rounded-full shadow-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounce">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
</body>

</html>
