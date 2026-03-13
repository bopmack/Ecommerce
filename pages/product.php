<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    setFlash('error', 'Product not found.');
    redirect(baseUrl('pages/products.php'));
}

$stmt = $pdo->prepare('SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.user_id = u.id WHERE p.id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    setFlash('error', 'Product not found.');
    redirect(baseUrl('pages/products.php'));
}

$pageTitle = $product['name'];

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    requireLogin();
    $qty = max(1, (int)($_POST['quantity'] ?? 1));

    $stmt = $pdo->prepare('SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?');
    $stmt->execute([currentUserId(), $id]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare('UPDATE cart_items SET quantity = quantity + ? WHERE id = ?');
        $stmt->execute([$qty, $existing['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([currentUserId(), $id, $qty]);
    }

    setFlash('success', 'Added to cart!');
    redirect(baseUrl('pages/product.php?id=' . $id));
}

// Related products
$relStmt = $pdo->prepare('SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.user_id = u.id WHERE p.category = ? AND p.id != ? ORDER BY RAND() LIMIT 4');
$relStmt->execute([$product['category'], $id]);
$related = $relStmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <div>
                <img class="product-detail-img"
                     src="<?= e($product['image_url'] ?: 'https://placehold.co/600x750/e8e8ed/86868b?text=No+Image') ?>"
                     alt="<?= e($product['name']) ?>">
            </div>
            <div class="product-detail-info">
                <div class="product-card-category"><?= e($product['category']) ?></div>
                <h1><?= e($product['name']) ?></h1>
                <div class="product-meta">
                    <span>Sold by <?= e($product['seller_name']) ?></span>
                    <span><?= $product['stock'] ?> in stock</span>
                    <span><?= date('M j, Y', strtotime($product['created_at'])) ?></span>
                </div>
                <div class="product-price"><?= formatPrice($product['price']) ?></div>

                <?php if ($product['description']): ?>
                    <div class="product-description">
                        <?= nl2br(e($product['description'])) ?>
                    </div>
                <?php endif; ?>

                <?php if ($product['stock'] > 0): ?>
                    <form method="POST" action="">
                        <div class="quantity-selector">
                            <label for="quantity">Qty</label>
                            <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1" max="<?= $product['stock'] ?>">
                        </div>
                        <button type="submit" name="add_to_cart" class="btn btn-accent btn-lg">Add to Cart</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-lg" disabled style="opacity:0.3;cursor:not-allowed">Sold Out</button>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($related)): ?>
            <div class="section" style="padding-bottom:0">
                <div class="section-header">
                    <h2>You may also like</h2>
                </div>
                <div class="products-grid">
                    <?php foreach ($related as $rel): ?>
                        <div class="product-card">
                            <a href="<?= baseUrl('pages/product.php?id=' . $rel['id']) ?>">
                                <img class="product-card-img"
                                     src="<?= e($rel['image_url'] ?: 'https://placehold.co/400x500/e8e8ed/86868b?text=No+Image') ?>"
                                     alt="<?= e($rel['name']) ?>"
                                     loading="lazy">
                            </a>
                            <div class="product-card-body">
                                <div class="product-card-category"><?= e($rel['category']) ?></div>
                                <h3 class="product-card-title">
                                    <a href="<?= baseUrl('pages/product.php?id=' . $rel['id']) ?>"><?= e($rel['name']) ?></a>
                                </h3>
                                <div class="product-card-footer">
                                    <span class="product-price"><?= formatPrice($rel['price']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
