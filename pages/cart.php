<?php
$pageTitle = 'Cart';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

// Handle update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $cartId = (int)$_POST['update_id'];
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $stmt = $pdo->prepare('UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$qty, $cartId, currentUserId()]);
    redirect(baseUrl('pages/cart.php'));
}

// Handle remove
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $cartId = (int)$_POST['remove_id'];
    $stmt = $pdo->prepare('DELETE FROM cart_items WHERE id = ? AND user_id = ?');
    $stmt->execute([$cartId, currentUserId()]);
    setFlash('success', 'Item removed.');
    redirect(baseUrl('pages/cart.php'));
}

// Fetch cart items
$stmt = $pdo->prepare('
    SELECT ci.*, p.name, p.price, p.image_url, p.stock
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ?
    ORDER BY ci.created_at DESC
');
$stmt->execute([currentUserId()]);
$cartItems = $stmt->fetchAll();

$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="cart-page">
    <div class="container">
        <h1>Cart</h1>

        <?php if (empty($cartItems)): ?>
            <div class="empty-state">
                <h2>Your cart is empty</h2>
                <p>Discover products and add them to your cart.</p>
                <a href="<?= baseUrl('pages/products.php') ?>" class="btn">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="cart-grid">
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <a href="<?= baseUrl('pages/product.php?id=' . $item['product_id']) ?>">
                                <img class="cart-item-img"
                                     src="<?= e($item['image_url'] ?: 'https://placehold.co/88x110/e8e8ed/86868b?text=No+Image') ?>"
                                     alt="<?= e($item['name']) ?>">
                            </a>
                            <div class="cart-item-info">
                                <h3><a href="<?= baseUrl('pages/product.php?id=' . $item['product_id']) ?>"><?= e($item['name']) ?></a></h3>
                                <div class="cart-item-price"><?= formatPrice($item['price']) ?></div>
                                <div class="cart-item-actions">
                                    <form method="POST" action="" class="cart-qty-form">
                                        <input type="hidden" name="update_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>">
                                        <button type="submit">Update</button>
                                    </form>
                                    <form method="POST" action="">
                                        <input type="hidden" name="remove_id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="cart-remove">Remove</button>
                                    </form>
                                </div>
                            </div>
                            <div class="cart-item-price" style="white-space:nowrap">
                                <?= formatPrice($item['price'] * $item['quantity']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal (<?= count($cartItems) ?> item<?= count($cartItems) !== 1 ? 's' : '' ?>)</span>
                        <span><?= formatPrice($subtotal) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span style="color:var(--success)">Free</span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span><?= formatPrice($subtotal) ?></span>
                    </div>
                    <a href="<?= baseUrl('pages/checkout.php') ?>" class="btn btn-accent btn-block btn-lg" style="margin-top:24px">Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
