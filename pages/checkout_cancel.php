<?php
$pageTitle = 'Payment Cancelled';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

$orderId = (int)($_GET['order_id'] ?? 0);

if ($orderId > 0) {
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ? AND user_id = ?');
    $stmt->execute(['cancelled', $orderId, currentUserId()]);
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="success-page">
    <div class="success-icon" style="border-color:var(--danger);color:var(--danger)">&#10007;</div>
    <h1>Payment Cancelled</h1>
    <p>Your payment was cancelled. Your cart items are still saved — you can try again anytime.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="<?= baseUrl('pages/cart.php') ?>" class="btn">Back to Cart</a>
        <a href="<?= baseUrl('pages/products.php') ?>" class="btn btn-outline">Browse Products</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
