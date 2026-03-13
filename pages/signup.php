<?php
$pageTitle = 'Sign Up';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

if (isLoggedIn()) {
    redirect(baseUrl());
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'A valid email is required.';
    }
    if (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'This email is already registered.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $hash]);

        $_SESSION['user_id'] = (int) $pdo->lastInsertId();
        $_SESSION['user_name'] = $name;
        setFlash('success', 'Welcome to ShopHub! Your account has been created.');
        redirect(baseUrl());
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card">
        <h1>Create Account</h1>
        <p class="subtitle">Join ShopHub to start buying and selling.</p>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= e($name) ?>" required>
                <?php if (isset($errors['name'])): ?>
                    <p class="form-error"><?= e($errors['name']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($email) ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <p class="form-error"><?= e($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" minlength="6" required>
                <?php if (isset($errors['password'])): ?>
                    <p class="form-error"><?= e($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <p class="form-error"><?= e($errors['confirm_password']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-block">Create Account</button>
        </form>

        <p class="form-footer">
            Already have an account? <a href="<?= baseUrl('pages/login.php') ?>">Log in</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
