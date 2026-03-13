<?php
$pageTitle = 'Products';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

$category = $_GET['category'] ?? '';
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'newest';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 12;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];

if ($category !== '') {
    $where[] = 'p.category = ?';
    $params[] = $category;
}

if ($search !== '') {
    $where[] = '(p.name LIKE ? OR p.description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$orderBy = match ($sort) {
    'price_asc' => 'p.price ASC',
    'price_desc' => 'p.price DESC',
    'name' => 'p.name ASC',
    default => 'p.created_at DESC',
};

// Count total
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM products p $whereSQL");
$countStmt->execute($params);
$total = (int) $countStmt->fetchColumn();
$totalPages = max(1, ceil($total / $perPage));

// Fetch products
$sql = "SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.user_id = u.id $whereSQL ORDER BY $orderBy LIMIT $perPage OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get categories for filter
$catStmt = $pdo->query('SELECT DISTINCT category FROM products ORDER BY category');
$allCategories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="section">
    <div class="container">
        <div class="section-header">
            <h2><?= $category ? e($category) : 'All Products' ?></h2>
            <span style="font-size:0.8rem;color:var(--text-tertiary)"><?= $total ?> product<?= $total !== 1 ? 's' : '' ?></span>
        </div>

        <form class="filters-bar" method="GET" action="">
            <input type="text" name="search" class="search-input" placeholder="Search..." value="<?= e($search) ?>">
            <select name="category" class="filter-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($allCategories as $cat): ?>
                    <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name A-Z</option>
            </select>
            <button type="submit" class="btn btn-sm">Search</button>
        </form>

        <?php if (empty($products)): ?>
            <div class="empty-state">
                <h2>No products found</h2>
                <p>Try adjusting your search or filters.</p>
                <a href="<?= baseUrl('pages/products.php') ?>" class="btn btn-ghost">Clear Filters</a>
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

            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php
                    $queryParams = $_GET;
                    for ($i = 1; $i <= $totalPages; $i++):
                        $queryParams['page'] = $i;
                        $url = '?' . http_build_query($queryParams);
                    ?>
                        <?php if ($i === $page): ?>
                            <span class="active"><?= $i ?></span>
                        <?php else: ?>
                            <a href="<?= e($url) ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
