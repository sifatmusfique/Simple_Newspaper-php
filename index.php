<?php
require_once 'config/database.php';

// --- Database ---
$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll();

// ---  Categories ---
$categories = ['Local News', 'Technology', 'Sports', 'Business', 'Entertainment', 'Culture', 'Health', 'International'];

$articles_by_category = [];
foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE category = ? ORDER BY created_at DESC LIMIT 4");
    $stmt->execute([$category]);
    $articles_by_category[$category] = $stmt->fetchAll();
}

$featured_articles = array_slice($articles, 0, 5);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rajshahi Chronicle</title>
    <link rel="stylesheet" href="dist/output.css">
    <!-- SwiperJS slider -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <style>
        
        .swiper-button-next, .swiper-button-prev {
            color: #ffffff;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 9999px;
            width: 36px; 
            height: 36px; 
            transition: background-color 0.3s ease;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background-color: rgba(0, 0, 0, 0.6);
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 1.25rem; 
            font-weight: 900;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans text-gray-800 dark:text-gray-200 antialiased transition-colors duration-300">

    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">
                <a href="#" class="text-3xl lg:text-4xl font-serif font-black text-gray-900 dark:text-white tracking-tight">The Rajshahi Chronicle</a>
                <div class="flex items-center">
                    <!-- Desktop Nav -->
                    <nav class="hidden md:flex items-center space-x-6 text-base font-semibold">
                        <?php foreach ($categories as $category): ?>
                            <a href="#<?= strtolower(str_replace(' ', '-', $category)) ?>" class="text-gray-700 dark:text-gray-300 hover:text-red-700 dark:hover:text-red-500 transition-colors duration-300"><?= htmlspecialchars($category) ?></a>
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
                         <!-- Hamburger Menu -->
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
                <a href="#<?= strtolower(str_replace(' ', '-', $category)) ?>" class="mobile-menu-link text-xl font-semibold text-gray-700 dark:text-gray-200 hover:text-red-700 dark:hover:text-red-500"><?= htmlspecialchars($category) ?></a>
            <?php endforeach; ?>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="admin/" class="mobile-menu-link text-xl font-semibold text-gray-700 dark:text-gray-200 hover:text-red-700 dark:hover:text-red-500">Admin Login</a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-10">

        <!-- Hero Slider Section -->
        <?php if (!empty($featured_articles)): ?>
        <section class="mb-16">
            <div class="swiper h-[550px] rounded-xl overflow-hidden shadow-2xl relative">
                <div class="swiper-wrapper">
                    <?php foreach ($featured_articles as $article): ?>
                    <div class="swiper-slide relative">
                        
                        <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-10 text-white">
                            <span class="inline-block bg-red-700 text-white text-sm font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider"><?= htmlspecialchars($article['category']) ?></span>
                            <h2 class="text-3xl sm:text-5xl font-serif font-bold leading-tight mb-3">
                                <a href="single.php?id=<?= $article['id'] ?>" class="hover:underline"><?= htmlspecialchars($article['title']) ?></a>
                            </h2>
                            <p class="text-gray-300 font-semibold"><?= date('F j, Y', strtotime($article['created_at'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        <?php endif; ?>

        <!-- News Sections -->
        <?php foreach ($categories as $category): ?>
        <section id="<?= strtolower(str_replace(' ', '-', $category)) ?>" class="mb-20">
            <div class="flex items-center border-b-4 border-gray-900 dark:border-gray-200 pb-3 mb-8">
                 <h2 class="text-3xl lg:text-4xl font-serif font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($category) ?></h2>
                 
            </div>
           
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php if (!empty($articles_by_category[$category])): ?>
                    <?php foreach ($articles_by_category[$category] as $article): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden group transform hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                            <a href="single.php?id=<?= $article['id'] ?>" class="block">
                                <div class="h-52 overflow-hidden">
                                    <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                                </div>
                                <div class="p-6">
                                    <span class="text-sm font-bold text-red-600 dark:text-red-500 uppercase tracking-wider"><?= htmlspecialchars($article['category']) ?></span>
                                    <h3 class="text-xl font-serif font-bold text-gray-900 dark:text-white mt-2 mb-3 leading-tight group-hover:text-red-700 dark:group-hover:text-red-500 transition-colors duration-300">
                                        <?= htmlspecialchars($article['title']) ?>
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                        <?= htmlspecialchars(substr($article['content'], 0, 90)) ?>...
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-4 font-semibold"><?= date('F j, Y', strtotime($article['created_at'])) ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 col-span-full">No articles found in this category yet.</p>
                <?php endif; ?>
            </div>
        </section>
        <?php endforeach; ?>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <a href="#" class="text-4xl font-serif font-black">The Rajshahi Chronicle</a>
            <p class="mt-5 max-w-2xl mx-auto text-gray-400">
                Bringing you the latest news from Rajshahi and around the world. Your trusted source for information and analysis since 2025.
            </p>
            <div class="mt-8 border-t border-gray-700 pt-8">
                <p class="text-gray-500">&copy; <?= date('Y') ?> The Rajshahi Chronicle. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    // Swiper JS Init
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper !== 'undefined') {
            const swiper = new Swiper('.swiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        } else {
            console.error('Swiper JS not loaded.');
        }
    });

    // Dark Mode Toggle Logic
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

    // Mobile Menu Toggle Logic
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

