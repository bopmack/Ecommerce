<?php
$pageTitle = 'My Products';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ? AND user_id = ?');
    $stmt->execute([$deleteId, currentUserId()]);
    setFlash('success', 'Product deleted.');
    redirect(baseUrl('pages/my_products.php'));
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([currentUserId()]);
$products = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="section">
    <div class="container">
        <div class="section-header">
            <h2>My Products</h2>
            <a href="<?= baseUrl('pages/create_product.php') ?>" class="btn btn-sm">Add New</a>
        </div>

        <?php if (empty($products)): ?>
            <div class="empty-state">
                <h2>No products yet</h2>
                <p>Start selling by listing your first product.</p>
                <a href="<?= baseUrl('pages/create_product.php') ?>" class="btn">List a Product</a>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
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
                            <div class="product-card-footer">
                                <span class="product-price"><?= formatPrice($product['price']) ?></span>
                                <span class="stock-indicator" style="color:var(--text-tertiary)"><?= $product['stock'] ?> in stock</span>
                            </div>
                            <div style="margin-top:12px;display:flex;gap:8px">
                                <a href="<?= baseUrl('pages/edit_product.php?id=' . $product['id']) ?>" class="btn btn-sm btn-ghost">Edit</a>
                                <form method="POST" action="" style="display:inline" onsubmit="return confirm('Delete this product?')">
                                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
