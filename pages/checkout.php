<?php
$pageTitle = 'Checkout';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

// Stripe keys — replace with your keys
$stripeSecretKey = ' ';
$stripePublishableKey = ' ';

// Fetch cart
$stmt = $pdo->prepare('
    SELECT ci.*, p.name, p.price, p.image_url, p.stock
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.user_id = ?
');
$stmt->execute([currentUserId()]);
$cartItems = $stmt->fetchAll();

if (empty($cartItems)) {
    setFlash('error', 'Your cart is empty.');
    redirect(baseUrl('pages/cart.php'));
}

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle Stripe Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Build Stripe line items
    $lineItems = [];
    foreach ($cartItems as $item) {
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item['name'],
                    'images' => $item['image_url'] ? [$item['image_url']] : [],
                ],
                'unit_amount' => (int)($item['price'] * 100),
            ],
            'quantity' => $item['quantity'],
        ];
    }

    // Create order in DB
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)');
        $stmt->execute([currentUserId(), $total, 'pending']);
        $orderId = $pdo->lastInsertId();

        foreach ($cartItems as $item) {
            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);

            // Reduce stock
            $stmt = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?');
            $stmt->execute([$item['quantity'], $item['product_id'], $item['quantity']]);
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        setFlash('error', 'Something went wrong. Please try again.');
        redirect(baseUrl('pages/checkout.php'));
    }

    // Create Stripe Checkout Session via cURL
    $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $stripeSecretKey . ':');

    $postData = [
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'success_url' => 'http://localhost:8888/capi/shop/pages/checkout_success.php?order_id=' . $orderId . '&session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost:8888/capi/shop/pages/checkout_cancel.php?order_id=' . $orderId,
        'metadata[order_id]' => $orderId,
    ];

    foreach ($lineItems as $i => $li) {
        $postData["line_items[$i][price_data][currency]"] = $li['price_data']['currency'];
        $postData["line_items[$i][price_data][product_data][name]"] = $li['price_data']['product_data']['name'];
        $postData["line_items[$i][price_data][unit_amount]"] = $li['price_data']['unit_amount'];
        $postData["line_items[$i][quantity]"] = $li['quantity'];
        if (!empty($li['price_data']['product_data']['images'])) {
            $postData["line_items[$i][price_data][product_data][images][0]"] = $li['price_data']['product_data']['images'][0];
        }
    }

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    $response = curl_exec($ch);
    curl_close($ch);

    $session = json_decode($response, true);

    if (isset($session['url'])) {
        // Update order with Stripe session ID
        $stmt = $pdo->prepare('UPDATE orders SET stripe_session_id = ? WHERE id = ?');
        $stmt->execute([$session['id'], $orderId]);

        // Clear cart
        $stmt = $pdo->prepare('DELETE FROM cart_items WHERE user_id = ?');
        $stmt->execute([currentUserId()]);

        header('Location: ' . $session['url']);
        exit;
    } else {
        // Stripe failed — mark order cancelled
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute(['cancelled', $orderId]);
        setFlash('error', 'Payment setup failed. Please check Stripe keys and try again.');
        redirect(baseUrl('pages/checkout.php'));
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="section">
    <div class="container">
        <div class="cart-grid">
            <div>
                <h1 style="font-size:clamp(1.4rem,3vw,1.8rem);font-weight:500;letter-spacing:-0.03em;margin-bottom:32px">Checkout</h1>
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <img class="cart-item-img"
                                 src="<?= e($item['image_url'] ?: 'https://placehold.co/88x110/e8e8ed/86868b?text=No+Image') ?>"
                                 alt="<?= e($item['name']) ?>">
                            <div class="cart-item-info">
                                <h3><?= e($item['name']) ?></h3>
                                <div style="font-size:0.8rem;color:var(--text-tertiary)">Qty: <?= $item['quantity'] ?></div>
                            </div>
                            <div class="cart-item-price"><?= formatPrice($item['price'] * $item['quantity']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="cart-summary">
                <h2>Payment Summary</h2>
                <?php foreach ($cartItems as $item): ?>
                    <div class="summary-row">
                        <span><?= e($item['name']) ?> &times;<?= $item['quantity'] ?></span>
                        <span><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span style="color:var(--success)">Free</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span><?= formatPrice($total) ?></span>
                </div>
                <form method="POST" action="">
                    <button type="submit" name="checkout" class="btn btn-accent btn-block btn-lg" style="margin-top:24px">
                        Pay with Stripe
                    </button>
                </form>
                <p style="text-align:center;font-size:0.7rem;color:var(--text-tertiary);margin-top:12px;letter-spacing:0.02em">
                    You will be redirected to Stripe's secure checkout.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
