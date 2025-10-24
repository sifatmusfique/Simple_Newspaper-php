<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans flex">

    <?php include 'common/sidebar.php'; ?>

    <!--header -->
    <header class="md:hidden bg-white dark:bg-gray-800 shadow-md sticky top-0 z-40 w-full">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
             <a href="dashboard.php" class="text-xl font-serif font-black text-gray-900 dark:text-white">Admin Panel</a>
             <button id="hamburger-button" class="text-gray-500 dark:text-gray-400 p-2.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </header>

    <div class="flex-1 p-4 sm:p-6 lg:p-8 ml-0 md:ml-64 transition-all duration-300">
        <h1 class="text-3xl font-bold font-serif text-gray-900 dark:text-white mb-6">Profile Settings</h1>
        <div class="max-w-lg bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Change Your Password</h2>
            
            <div id="response-message" class="mb-4 hidden"></div>

            <form id="password-change-form">
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                </div>
                <div class="mb-6">
                    <label for="new_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                </div>
                 <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">Update Password</button>
            </form>
        </div>
    </div>
    
    <script>
        
    </script>
    <script src="common/theme_switcher.js"></script>
    <script>
        
        document.getElementById('hamburger-button').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>

