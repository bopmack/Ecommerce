<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

$cartCount = isLoggedIn() ? getCartCount($pdo, currentUserId()) : 0;
$flash = getFlash();
$pageTitle = $pageTitle ?? 'ShopHub';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> &mdash; ShopHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= baseUrl('assets/css/style.css') ?>">
    <script>
        (function() {
            var t = localStorage.getItem('theme');
            if (t) document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="<?= baseUrl() ?>" class="logo">
                <span class="logo-mark">ShopHub</span>
            </a>

            <div class="nav-links">
                <a href="<?= baseUrl('pages/products.php') ?>">Shop</a>
                <?php if (isLoggedIn()): ?>
                    <a href="<?= baseUrl('pages/create_product.php') ?>">Sell</a>
                    <a href="<?= baseUrl('pages/cart.php') ?>" class="cart-link">
                        Cart<?php if ($cartCount > 0): ?><span class="cart-badge"><?= $cartCount ?></span><?php endif; ?>
                    </a>
                    <div class="user-menu">
                        <button class="user-menu-btn"><?= e(currentUserName()) ?></button>
                        <div class="user-dropdown">
                            <a href="<?= baseUrl('pages/my_products.php') ?>">My Products</a>
                            <a href="<?= baseUrl('pages/orders.php') ?>">Orders</a>
                            <a href="<?= baseUrl('pages/logout.php') ?>" class="logout-link">Log out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= baseUrl('pages/login.php') ?>">Log in</a>
                    <a href="<?= baseUrl('pages/signup.php') ?>" class="btn btn-sm">Sign Up</a>
                <?php endif; ?>
            </div>

            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                </button>
                <button class="mobile-toggle" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    <?php if ($flash): ?>
        <div class="flash flash-<?= e($flash['type']) ?>">
            <div class="container"><?= e($flash['message']) ?></div>
        </div>
    <?php endif; ?>

    <main>
