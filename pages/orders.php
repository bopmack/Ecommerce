<?php
$pageTitle = 'My Orders';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([currentUserId()]);
$orders = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<div class="orders-page">
    <div class="container">
        <h1>My Orders</h1>

        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <h2>No orders yet</h2>
                <p>When you make a purchase, your orders will appear here.</p>
                <a href="<?= baseUrl('pages/products.php') ?>" class="btn">Browse Products</a>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <?php
                $itemsStmt = $pdo->prepare('
                    SELECT oi.*, p.name
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = ?
                ');
                $itemsStmt->execute([$order['id']]);
                $orderItems = $itemsStmt->fetchAll();
                ?>
                <div class="order-card">
                    <div class="order-header">
                        <span><strong>Order #<?= $order['id'] ?></strong></span>
                        <span><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></span>
                        <span class="order-status status-<?= e($order['status']) ?>"><?= e($order['status']) ?></span>
                    </div>
                    <div class="order-items">
                        <?php foreach ($orderItems as $oi): ?>
                            <div class="order-item">
                                <span><?= e($oi['name']) ?> &times; <?= $oi['quantity'] ?></span>
                                <span><?= formatPrice($oi['price'] * $oi['quantity']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="order-total">Total: <?= formatPrice($order['total']) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
