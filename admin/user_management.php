<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    die('<!DOCTYPE html><html><head><title>Forbidden</title></head><body><h1>403 Forbidden</h1><p>You do not have permission to access this page.</p></body></html>');
}

require_once '../config/database.php';
$stmt = $pdo->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans flex">

    <?php include 'common/sidebar.php'; ?>

    <!-- header -->
    <header class="md:hidden bg-white dark:bg-gray-800 shadow-md sticky top-0 z-40 w-full">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="dashboard.php" class="text-xl font-serif font-black text-gray-900 dark:text-white">Admin Panel</a>
            <button id="hamburger-button" class="text-gray-500 dark:text-gray-400 p-2.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </header>

    <div class="flex-1 p-4 sm:p-6 lg:p-8 ml-0 md:ml-64 transition-all duration-300">
        <h1 class="text-3xl font-bold font-serif text-gray-900 dark:text-white mb-6">User Management</h1>
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="p-4 font-semibold text-sm uppercase">Username</th>
                            <th class="p-4 font-semibold text-sm uppercase">Role</th>
                            <th class="p-4 font-semibold text-sm uppercase">Member Since</th>
                            <th class="p-4 font-semibold text-sm uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="p-4 font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="p-4">
                                    <?php if ($user['username'] === 'admin'): ?>
                                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Admin</span>
                                    <?php else: ?>
                                        <select class="role-select bg-gray-100 dark:bg-gray-700 rounded-lg p-2 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500" data-userid="<?= $user['id'] ?>">
                                            <option value="moderator" <?= ($user['role'] === 'moderator') ? 'selected' : '' ?>>Moderator</option>
                                            <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-gray-500 dark:text-gray-400 text-sm"><?= date('F j, Y', strtotime($user['created_at'])) ?></td>
                                <td class="p-4 text-right">

                                    <?php if ($user['username'] !== 'admin'): ?>
                                        <button class="delete-user-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors" data-userid="<?= $user['id'] ?>">Delete</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {


        });
    </script>
    <script src="common/theme_switcher.js"></script>
    <script>
        document.getElementById('hamburger-button').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>