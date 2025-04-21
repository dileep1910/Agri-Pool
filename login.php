<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = trim($_POST["username"]);
    $input_password = trim($_POST["password"]);

    // Hardcoded credentials for demo (no database)
    $valid_password = "agripool2025";
    $valid_username = "agripool";
    if (empty($input_username) || empty($input_password)) {
        $error = "Please fill in all fields.";
    } elseif ($input_username === $valid_username && $input_password === $valid_password)  {
        // Login success
        $_SESSION['user_id'] = 1; // Dummy ID
        $_SESSION['username'] = $input_username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agri Pool</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-lg">
        <header class="fixed top-0 left-0 w-full px-4 z-50 flex items-center justify-between p-4 text-white bg-green-900">
            <div class="flex items-center">
                <img src="logopro.png" alt="Agri Pool Logo" class="h-12">
            </div>
            <h1 class="text-4xl font-bold absolute left-1/2 transform -translate-x-1/2">
                Agri Pool
            </h1>
            <div class="w-12"></div>
        </header>
        <!-- Logo -->
        <img src="logopro.png" alt="Agri Pool Logo" class="h-16 mx-auto mb-4">
        <!-- Welcome Text -->
        <h2 class="text-2xl font-bold text-green-900 text-center mb-4">Welcome to AgriPool</h2>
        <!-- Login/Register Title -->
        <h1 class="text-2xl font-bold text-green-900 mb-4 text-center">
            Login / <a href="register.php" class="text-blue-600 hover:underline">Register</a>
        </h1>
        <!-- Error Message -->
        <?php if ($error): ?>
            <p class="text-red-600 text-center mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <!-- Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-900" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-900" required>
            </div>
            <button type="submit" class="w-full bg-green-900 text-white p-2 rounded hover:bg-green-700 transition">Login</button>
        </form>
    </div>
</body>
</html>