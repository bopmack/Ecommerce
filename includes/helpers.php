<?php
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $price): string {
    return '$' . number_format($price, 2);
}

function getCartCount(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare('SELECT COALESCE(SUM(quantity), 0) FROM cart_items WHERE user_id = ?');
    $stmt->execute([$userId]);
    return (int) $stmt->fetchColumn();
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function baseUrl(string $path = ''): string {
    return '/capi/shop/' . ltrim($path, '/');
}
