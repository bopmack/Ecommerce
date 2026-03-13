<?php
$pageTitle = 'Edit Product';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';
requireLogin();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND user_id = ?');
$stmt->execute([$id, currentUserId()]);
$product = $stmt->fetch();

if (!$product) {
    setFlash('error', 'Product not found or access denied.');
    redirect(baseUrl('pages/my_products.php'));
}

$categories = ['Electronics', 'Fashion', 'Home', 'Sports', 'Books', 'Toys', 'Beauty', 'Automotive', 'Other'];
$errors = [];

$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image_url = $product['image_url'];
$category = $product['category'];
$stock = $product['stock'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $stock = trim($_POST['stock'] ?? '');

    if ($name === '') $errors['name'] = 'Product name is required.';
    if ($price === '' || !is_numeric($price) || (float)$price <= 0) $errors['price'] = 'A valid price is required.';
    if ($category === '') $errors['category'] = 'Please select a category.';
    if ($stock === '' || !ctype_digit((string)$stock)) $errors['stock'] = 'Stock must be a whole number.';

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, category = ?, stock = ? WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$name, $description, (float)$price, $image_url ?: null, $category, (int)$stock, $id, currentUserId()]);
        setFlash('success', 'Product updated!');
        redirect(baseUrl('pages/product.php?id=' . $id));
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="create-page">
    <div class="create-card">
        <h1>Edit Product</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= e($name) ?>" required>
                <?php if (isset($errors['name'])): ?><p class="form-error"><?= e($errors['name']) ?></p><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"><?= e($description) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?= e($price) ?>" step="0.01" min="0.01" required>
                    <?php if (isset($errors['price'])): ?><p class="form-error"><?= e($errors['price']) ?></p><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="<?= e($stock) ?>" min="0" required>
                    <?php if (isset($errors['stock'])): ?><p class="form-error"><?= e($errors['stock']) ?></p><?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['category'])): ?><p class="form-error"><?= e($errors['category']) ?></p><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="url" id="image_url" name="image_url" class="form-control" value="<?= e($image_url) ?>">
                <div class="image-preview" id="imagePreview">
                    <?php if ($image_url): ?>
                        <img src="<?= e($image_url) ?>" alt="Preview">
                    <?php else: ?>
                        Image preview will appear here
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-lg">Update Product</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
