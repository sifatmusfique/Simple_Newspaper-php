<?php
session_start();

if (!isset($_SESSION['loggedin']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'moderator')) {
    header('Location: index.php');
    exit;
}

require_once '../config/database.php';
$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans flex">

    <?php include 'common/sidebar.php'; ?>

    <!--header-->
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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold font-serif text-gray-900 dark:text-white">Manage Articles</h1>
            <button id="add-article-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline">Add New Article</span>
            </button>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
            <!--Card View -->
            <div class="md:hidden">
                <?php foreach ($articles as $article): ?>
                    <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-start space-x-4">
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Article Image" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                            <div class="flex-grow min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate"><?= htmlspecialchars($article['title']) ?></h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($article['category']) ?></p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1"><?= date('F j, Y', strtotime($article['created_at'])) ?></p>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <button class="edit-btn text-sm bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-semibold py-1 px-3 rounded-lg transition-colors" data-id="<?= $article['id'] ?>">Edit</button>
                            <button class="delete-btn text-sm bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded-lg transition-colors" data-id="<?= $article['id'] ?>">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="p-4 font-semibold text-sm uppercase">Title</th>
                            <th class="p-4 font-semibold text-sm uppercase">Category</th>
                            <th class="p-4 font-semibold text-sm uppercase">Date</th>
                            <th class="p-4 font-semibold text-sm uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        <?php foreach ($articles as $article): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20">
                                <td class="p-4 font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($article['title']) ?></td>
                                <td class="p-4 text-gray-500 dark:text-gray-400"><?= htmlspecialchars($article['category']) ?></td>
                                <td class="p-4 text-gray-500 dark:text-gray-400 text-sm"><?= date('F j, Y', strtotime($article['created_at'])) ?></td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <button class="edit-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition-colors" data-id="<?= $article['id'] ?>">Edit</button>
                                        <button class="delete-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors" data-id="<?= $article['id'] ?>">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Article -->
    <div id="article-modal" class="fixed inset-0 bg-black bg-opacity-60 items-center justify-center z-[100] hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 sm:p-8 w-11/12 md:w-2/3 lg:w-1/2 max-w-4xl max-h-screen overflow-y-auto">
            <h2 id="modal-title" class="text-2xl font-bold font-serif mb-6 text-gray-900 dark:text-white">Add New Article</h2>
            <form id="article-form">
                <input type="hidden" id="article-id" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                        <input type="text" id="title" name="title" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select id="category" name="category" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                            <option>Local News</option>
                            <option>Technology</option>
                            <option>Sports</option>
                            <option>Business</option>
                            <option>Entertainment</option>
                            <option>Culture</option>
                            <option>Health</option>
                            <option>International</option>
                        </select>
                    </div>
                    <div>
                        <label for="image_url" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
                        <input type="url" id="image_url" name="image_url" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="content" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Content</label>
                        <textarea id="content" name="content" rows="10" class="w-full p-3 bg-gray-100 dark:bg-gray-700 border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 rounded-lg" required></textarea>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" id="cancel-btn" class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-bold py-2 px-6 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">Save Article</button>
                </div>
            </form>
        </div>
    </div>

    <script src="dashboard.js" defer></script>
    <script src="common/theme_switcher.js"></script>
    <script>
        document.getElementById('hamburger-button').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>