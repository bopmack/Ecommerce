<?php
$pageTitle = 'Login';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

if (isLoggedIn()) {
    redirect(baseUrl());
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors['login'] = 'Email and password are required.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, name, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user_name'] = $user['name'];
            setFlash('success', 'Welcome back, ' . $user['name'] . '!');
            redirect(baseUrl());
        } else {
            $errors['login'] = 'Invalid email or password.';
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card">
        <h1>Welcome Back</h1>
        <p class="subtitle">Log in to your ShopHub account.</p>

        <?php if (isset($errors['login'])): ?>
            <div style="margin-bottom:20px;padding:12px;border:1px solid var(--danger);color:var(--danger);font-size:0.8rem;background:var(--danger-subtle)">
                <?= e($errors['login']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($email) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-block">Log In</button>
        </form>

        <p class="form-footer">
            Don't have an account? <a href="<?= baseUrl('pages/signup.php') ?>">Sign up</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
