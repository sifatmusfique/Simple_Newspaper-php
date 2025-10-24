<?php
require 'config/database.php';


$id = $_GET['id'] ?? null;
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php");
    exit;
}

// Define categories for navigation
$categories = ['Local News', 'Technology', 'Sports', 'Business', 'Entertainment', 'Culture', 'Health', 'International'];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - The Rajshahi Chronicle</title>
    <link href="./dist/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .article-content p {
            margin-bottom: 1.5rem; 
            line-height: 1.8; 
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans text-gray-800 dark:text-gray-200 antialiased transition-colors duration-300">

    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-3xl lg:text-4xl font-serif font-black text-gray-900 dark:text-white tracking-tight">The Rajshahi Chronicle</a>
                <div class="flex items-center">
                    <!-- Desktop Nav -->
                    <nav class="hidden md:flex items-center space-x-6 text-base font-semibold">
                        <?php foreach ($categories as $category): ?>
                            <a href="index.php#<?= strtolower(str_replace(' ', '-', $category)) ?>" class="text-gray-700 dark:text-gray-300 hover:text-red-700 dark:hover:text-red-500 transition-colors duration-300"><?= htmlspecialchars($category) ?></a>
                        <?php endforeach; ?>
                    </nav>
                    
                    <div class="hidden md:block w-px h-6 bg-gray-300 dark:bg-gray-600 mx-6"></div>
                    
                    <!-- Right side icons -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                         <a href="admin/" class="hidden sm:block text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-red-700 dark:hover:text-red-500 transition-colors duration-300">Admin Login</a>
                         <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05A1 1 0 016.465 3.636l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM2 11a1 1 0 100-2H1a1 1 0 100 2h1zM13.536 14.95a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414z"></path></svg>
                        </button>
                         <!-- Hamburger Menu Button -->
                        <button id="mobile-menu-button" class="md:hidden text-gray-500 dark:text-gray-400 p-2.5 -mr-2.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed top-0 right-0 h-full w-72 bg-white dark:bg-gray-800 shadow-xl z-[60] transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex justify-end p-4">
            <button id="close-menu-button">
                <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex flex-col p-6 space-y-6">
            <?php foreach ($categories as $category): ?>
                <a href="index.php#<?= strtolower(str_replace(' ', '-', $category)) ?>" class="mobile-menu-link text-xl font-semibold text-gray-700 dark:text-gray-200 hover:text-red-700 dark:hover:text-red-500"><?= htmlspecialchars($category) ?></a>
            <?php endforeach; ?>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="admin/" class="mobile-menu-link text-xl font-semibold text-gray-700 dark:text-gray-200 hover:text-red-700 dark:hover:text-red-500">Admin Login</a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 md:py-12">
        <article class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 sm:p-8 lg:p-12 rounded-lg shadow-xl">
            <!-- Article Header -->
            <header class="mb-8 border-b dark:border-gray-700 pb-6">
                <p class="text-sm text-red-600 dark:text-red-500 uppercase font-bold tracking-wider"><?php echo htmlspecialchars($article['category']); ?></p>
                <h1 class="text-4xl md:text-5xl font-bold font-serif text-gray-900 dark:text-white my-4 leading-tight"><?php echo htmlspecialchars($article['title']); ?></h1>
                <p class="text-gray-600 dark:text-gray-400">Published on <?php echo date('F j, Y', strtotime($article['created_at'])); ?></p>
            </header>
            
            <!-- Featured Image -->
            <figure class="mb-8">
                <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-auto rounded-lg shadow-md">
            </figure>

            <!-- Article Body -->
            <div class="prose prose-lg max-w-none article-content font-serif text-lg text-gray-800 dark:text-gray-300" style="font-family: 'Merriweather', serif;">
                <?php
                
                    $paragraphs = explode("\n", htmlspecialchars($article['content']));
                    foreach ($paragraphs as $p) {
                        $trimmed_p = trim($p); 
                        if (!empty($trimmed_p)) {
                            echo "<p>" . $trimmed_p . "</p>";
                        }
                    }
                ?>
            </div>

            <!-- Home -->
            <div class="mt-12 pt-6 border-t dark:border-gray-700 text-center">
                <a href="index.php" class="text-red-600 dark:text-red-500 hover:underline font-semibold transition-colors">&larr; Back to all articles</a>
            </div>
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white py-16 mt-12">
        <div class="container mx-auto px-6 text-center">
            <a href="index.php" class="text-4xl font-serif font-black">The Rajshahi Chronicle</a>
            <p class="mt-5 max-w-2xl mx-auto text-gray-400">
                Bringing you the latest news from Rajshahi and around the world. Your trusted source for information and analysis since 2025.
            </p>
            <div class="mt-8 border-t border-gray-700 pt-8">
                <p class="text-gray-500">&copy; <?php echo date('Y'); ?> The Rajshahi Chronicle. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    // Dark Mode Toggle
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleBtn = document.getElementById('theme-toggle');
    const applyTheme = () => {
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if(themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
            if(themeToggleDarkIcon) themeToggleDarkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            if(themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
            if(themeToggleLightIcon) themeToggleLightIcon.classList.add('hidden');
        }
    };
    applyTheme(); 
    themeToggleBtn.addEventListener('click', () => {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
        applyTheme();
    });

    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenuButton = document.getElementById('close-menu-button');
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');

    const openMenu = () => mobileMenu && mobileMenu.classList.remove('translate-x-full');
    const closeMenu = () => mobileMenu && mobileMenu.classList.add('translate-x-full');

    if (mobileMenuButton) mobileMenuButton.addEventListener('click', openMenu);
    if (closeMenuButton) closeMenuButton.addEventListener('click', closeMenu);
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', closeMenu); 
    });
    </script>
</body>
</html>

