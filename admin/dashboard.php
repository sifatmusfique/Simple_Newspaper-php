<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
require_once '../config/database.php';

$total_articles = $pdo->query("SELECT count(*) FROM articles")->fetchColumn();
$total_users = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
$articles = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC")->fetchAll();
$users = $pdo->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body class="bg-gray-50 dark:bg-gray-900 font-sans">

    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-40">
        <div class="container mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</p>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-4">
                <a href="../index.php" target="_blank" class="text-sm font-semibold text-blue-600 dark:text-blue-500 hover:underline">View Live Site</a>
                <a href="logout.php" class="text-sm font-semibold text-red-600 dark:text-red-500 hover:underline">Logout</a>
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05A1 1 0 016.465 3.636l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM2 11a1 1 0 100-2H1a1 1 0 100 2h1zM13.536 14.95a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8 space-y-12">

        <!-- Section 1: Dashboard Overview -->
        <section id="dashboard-overview">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Overview</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="text-white p-6 rounded-xl shadow-lg" style="background-image: linear-gradient(to bottom right, #a855f7, #6366f1);">
                    <h3 class="text-lg font-semibold">Total Articles</h3>
                    <p class="text-4xl font-bold mt-2"><?= $total_articles ?></p>
                </div>
                <div class="text-white p-6 rounded-xl shadow-lg" style="background-image: linear-gradient(to bottom right, #38bdf8, #06b6d4);">
                    <h3 class="text-lg font-semibold">Registered Users</h3>
                    <p class="text-4xl font-bold mt-2"><?= $total_users ?></p>
                </div>
            </div>
        </section>

        <!-- Section 2: Manage Articles -->
        <section id="manage-articles">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Articles</h2>
                <button id="add-article-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center space-x-2 w-full sm:w-auto"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg><span>Add New Article</span></button>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase">Title</th>
                                <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase hidden md:table-cell">Category</th>
                                <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach ($articles as $article): ?>
                                <tr class="transition-colors duration-150 hover:bg-black/5">
                                    <td class="p-4 font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($article['title']) ?></td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400 hidden md:table-cell"><?= htmlspecialchars($article['category']) ?></td>
                                    <td class="p-4 text-right whitespace-nowrap">
                                        <button class="edit-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 font-bold py-2 px-3 rounded-lg text-xs sm:text-sm" data-id="<?= $article['id'] ?>">Edit</button>
                                        <button class="delete-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-lg ml-2 text-xs sm:text-sm" data-id="<?= $article['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Section 3: User Management -->
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <section id="user-management">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">User Management</h2>
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase">Username</th>
                                        <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase">Role</th>
                                        <th class="p-4 font-semibold text-sm text-gray-600 dark:text-gray-300 uppercase text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php foreach ($users as $user): ?>
                                        <tr class="transition-colors duration-150 hover:bg-black/5">
                                            <td class="p-4 font-semibold text-gray-800 dark:text-white"><?= htmlspecialchars($user['username']) ?></td>
                                            <td class="p-4"><?php if ($user['username'] === 'admin'): ?><span class="px-3 py-1 text-sm font-bold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Admin</span><?php else: ?><select class="role-select bg-gray-100 dark:bg-gray-700 rounded-lg p-2" data-userid="<?= $user['id'] ?>">
                                                        <option value="moderator" <?= ($user['role'] === 'moderator') ? 'selected' : '' ?>>Moderator</option>
                                                        <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                                    </select><?php endif; ?></td>
                                            <td class="p-4 text-right"><?php if ($user['username'] !== 'admin'): ?><button class="delete-user-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-lg text-xs sm:text-sm" data-userid="<?= $user['id'] ?>">Delete</button><?php endif; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Section 4: Profile Settings -->
            <section id="profile-settings">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Profile Settings</h2>
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Change Your Password</h3>
                    <div id="response-message" class="mb-4 hidden"></div>
                    <form id="password-change-form">
                        <div class="mb-4"><label for="current_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Current Password</label><input type="password" id="current_password" name="current_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required></div>
                        <div class="mb-6"><label for="new_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">New Password</label><input type="password" id="new_password" name="new_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required></div>
                        <div class="mb-6"><label for="confirm_password" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label><input type="password" id="confirm_password" name="confirm_password" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required></div><button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">Update Password</button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Add/Edit Article -->
    <!-- Outer div uses flexbox to center the inner div -->
    <div id="article-modal" class="fixed inset-0 bg-black bg-opacity-60 items-center justify-center p-4 z-[100] hidden">
         <!-- Inner div defines the modal's size and content -->
        <div class="bg-white dark:bg-gray-800 rounded-1xl shadow-2xl p-6 sm:p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h2 id="modal-title" class="text-2xl font-bold font-serif mb-6 text-gray-800 dark:text-white">Add New Article</h2>
            <form id="article-form" enctype="multipart/form-data"><input type="hidden" id="article-id" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2"><label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Title</label><input type="text" id="title" name="title" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required></div>
                    <div><label for="category" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Category</label><select id="category" name="category" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required>
                            <option>Local News</option>
                            <option>Technology</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Entertainment</option>
                            <option>Culture</option>
                            <option>Health</option>
                            <option>International</option>
                        </select></div>
                    <div><label for="image_file" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Image File</label><input type="file" id="image_file" name="image_file" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" accept="image/*" required><input type="hidden" id="existing_image_path" name="existing_image_path">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave blank to keep existing image when editing.</p>
                    </div>
                    <div class="md:col-span-2"><label for="content" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Content</label><textarea id="content" name="content" rows="8" class="w-full p-3 bg-gray-100 dark:bg-gray-700 rounded-lg" required></textarea></div>
                </div>
                <div class="mt-8 flex justify-end space-x-4"><button type="button" id="cancel-btn" class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 font-bold py-2 px-6 rounded-lg">Cancel</button><button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">Save Article</button></div>
            </form>
        </div>
    </div>

    <script src="dashboard.js"></script>
    <script src="user_management.js"></script>
    <script>
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeToggleBtn = document.getElementById('theme-toggle');
        const applyTheme = () => {
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.add('hidden');
            }
        };
        applyTheme();
        themeToggleBtn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
            applyTheme();
        });


        const passwordForm = document.getElementById('password-change-form');
        const responseMessage = document.getElementById('response-message');
        if (passwordForm) {
            passwordForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(passwordForm);
                if (formData.get('new_password') !== formData.get('confirm_password')) {
                    responseMessage.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">New passwords do not match.</div>`;
                    responseMessage.classList.remove('hidden');
                    return;
                }
                formData.append('action', 'change_password');
                try {
                    const response = await fetch('user_api.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    const color = result.success ? 'green' : 'red';
                    responseMessage.innerHTML = `<div class="bg-${color}-100 border border-${color}-400 text-${color}-700 px-4 py-3 rounded-lg">${result.message}</div>`;
                    responseMessage.classList.remove('hidden');
                    if (result.success) passwordForm.reset();
                } catch (error) {
                    responseMessage.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">An unexpected error occurred.</div>`;
                    responseMessage.classList.remove('hidden');
                }
            });
        }


        const cancelBtn = document.getElementById('cancel-btn');
        const imageFileInput = document.getElementById('image_file');
        const existingImagePathInput = document.getElementById('existing_image_path');
        const closeModal = () => {
            document.getElementById('article-modal').classList.add('hidden');
            document.getElementById('article-form').reset();
            document.getElementById('article-id').value = '';
            existingImagePathInput.value = '';
        };
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
    </script>
</body>

</html>

