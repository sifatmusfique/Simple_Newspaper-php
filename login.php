<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - The Rajshahi Chronicle</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-serif font-black text-gray-900 dark:text-white">Admin Panel Login</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">The Rajshahi Chronicle</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <strong class="font-bold">Login failed!</strong>
                <span class="block sm:inline">Invalid username or password.</span>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-5">
                <label for="username" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-300">Login</button>
        </form>
    </div>

</body>
</html>

