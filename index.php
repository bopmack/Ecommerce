<?php
$pageTitle = 'Home';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';

// Featured products (newest 8)
$stmt = $pdo->query('SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT 8');
$featured = $stmt->fetchAll();

// Categories with counts
$catStmt = $pdo->query('SELECT category, COUNT(*) AS cnt FROM products GROUP BY category ORDER BY cnt DESC');
$categories = $catStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-eyebrow">The open marketplace</div>
                <h1>Find things<br>you'll love</h1>
                <p>A curated marketplace where anyone can discover unique products or list their own. Quality goods, transparent pricing, secure checkout.</p>
                <div class="hero-actions">
                    <a href="<?= baseUrl('pages/products.php') ?>" class="btn btn-lg">Shop Now</a>
                    <?php if (isLoggedIn()): ?>
                        <a href="<?= baseUrl('pages/create_product.php') ?>" class="btn btn-lg btn-outline">Start Selling</a>
                    <?php else: ?>
                        <a href="<?= baseUrl('pages/signup.php') ?>" class="btn btn-lg btn-outline">Create Account</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image-grid">
                    <img class="hero-img" src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&h=900&fit=crop" alt="Store">
                    <img class="hero-img" src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=440&fit=crop" alt="Shopping">
                    <img class="hero-img" src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=440&fit=crop" alt="Products">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<?php if (!empty($categories)): ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Categories</h2>
            <a href="<?= baseUrl('pages/products.php') ?>">View all</a>
        </div>
        <div class="categories-grid">
            <?php foreach ($categories as $cat): ?>
                <a href="<?= baseUrl('pages/products.php?category=' . urlencode($cat['category'])) ?>" class="category-card">
                    <span class="category-label"><?= e($cat['category']) ?></span>
                    <span class="category-count"><?= $cat['cnt'] ?> product<?= $cat['cnt'] != 1 ? 's' : '' ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Products -->
<?php if (!empty($featured)): ?>
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>New arrivals</h2>
            <a href="<?= baseUrl('pages/products.php') ?>">Shop all</a>
        </div>
        <div class="products-grid">
            <?php foreach ($featured as $product): ?>
                <div class="product-card">
                    <a href="<?= baseUrl('pages/product.php?id=' . $product['id']) ?>">
                        <img class="product-card-img"
                             src="<?= e($product['image_url'] ?: 'https://placehold.co/400x500/e8e8ed/86868b?text=No+Image') ?>"
                             alt="<?= e($product['name']) ?>"
                             loading="lazy">
                    </a>
                    <div class="product-card-body">
                        <div class="product-card-category"><?= e($product['category']) ?></div>
                        <h3 class="product-card-title">
                            <a href="<?= baseUrl('pages/product.php?id=' . $product['id']) ?>"><?= e($product['name']) ?></a>
                        </h3>
                        <p class="product-seller">by <?= e($product['seller_name']) ?></p>
                        <div class="product-card-footer">
                            <span class="product-price"><?= formatPrice($product['price']) ?></span>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="stock-indicator stock-in">In Stock</span>
                            <?php else: ?>
                                <span class="stock-indicator stock-out">Sold Out</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Value Props -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Built different</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-number">01</div>
                <h3>Secure checkout</h3>
                <p>Every transaction is processed through Stripe with bank-level encryption.</p>
            </div>
            <div class="feature-card">
                <div class="feature-number">02</div>
                <h3>Free shipping</h3>
                <p>No hidden fees. Free shipping on every order, delivered to your door.</p>
            </div>
            <div class="feature-card">
                <div class="feature-number">03</div>
                <h3>Sell in minutes</h3>
                <p>Create an account, list your product, and start earning. No setup fees.</p>
            </div>
            <div class="feature-card">
                <div class="feature-number">04</div>
                <h3>Curated quality</h3>
                <p>Every product from trusted sellers who care about what they make.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-banner">
    <div class="container">
        <h2>Start selling today</h2>
        <p>Join a growing community of sellers. List your products, reach new customers, and grow your business.</p>
        <?php if (!isLoggedIn()): ?>
            <a href="<?= baseUrl('pages/signup.php') ?>" class="btn btn-lg">Get Started</a>
        <?php else: ?>
            <a href="<?= baseUrl('pages/create_product.php') ?>" class="btn btn-lg">List a Product</a>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
