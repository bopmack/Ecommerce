<?php
$pageTitle = 'Order Confirmed';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

$orderId = (int)($_GET['order_id'] ?? 0);

if ($orderId > 0) {
    // Mark order as paid
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ? AND user_id = ?');
    $stmt->execute(['paid', $orderId, currentUserId()]);
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="success-page">
    <div class="success-icon">&#10003;</div>
    <h1>Order Confirmed!</h1>
    <p>Your order #<?= $orderId ?> has been placed successfully. Thank you for shopping with ShopHub!</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="<?= baseUrl('pages/orders.php') ?>" class="btn">View My Orders</a>
        <a href="<?= baseUrl('pages/products.php') ?>" class="btn btn-outline">Continue Shopping</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
