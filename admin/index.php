<?php
session_start();
// If the user is already logged in, redirect them to the dashboard
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
    <style>
        /* Animation for the login box */
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-box-animation {
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }
        /* Input focus animation */
        input:focus {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }
        /* Button hover/active animation */
        button[type="submit"] {
            transition: transform 0.2s ease, background-image 0.3s ease, box-shadow 0.2s ease; /* Added background-image transition */
        }
        button[type="submit"]:hover {
            transform: translateY(-2px);
             /* Add a slightly darker gradient on hover if desired, or adjust shadow */
             box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Example: Larger shadow on hover */
        }
         button[type="submit"]:active {
            transform: translateY(1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Example: Smaller shadow when active */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 dark:from-gray-800 dark:via-gray-900 dark:to-black font-sans flex items-center justify-center min-h-screen p-4">

    <!-- Added animation class -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 login-box-animation">
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
                <input type="text" id="username" name="username" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-transform duration-200" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full p-3 pr-10 bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-transform duration-200" required>
                    <button type="button" id="toggle-password" class="absolute top-1/2 right-0 transform -translate-y-1/2 p-3 text-gray-500 dark:text-gray-400">
                        <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg id="eye-slash-icon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.454.364m-3.03 3.03a3 3 0 11-4.243 4.243m4.242-4.242L18.5 18.5M3 3l3.03 3.03m0 0A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-2.454 4.636"></path></svg>
                    </button>
                </div>
            </div>
            <!-- Removed Tailwind gradient classes, added inline style -->
            <button type="submit" 
                    style="background-image: linear-gradient(to right, #4f46e5, #6366f1);" 
                    class="w-full text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                Login
            </button>
        </form>
         <div class="text-center mt-6">
            <a href="../index.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                &larr; Back to Main Site
            </a>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the icon visibility
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>

</body>
</html>

