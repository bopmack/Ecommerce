    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-brand">ShopHub</div>
                    <p>An open marketplace for unique products. Buy and sell with confidence.</p>
                </div>
                <div class="footer-col">
                    <h4>Shop</h4>
                    <a href="<?= baseUrl('pages/products.php') ?>">All Products</a>
                    <a href="<?= baseUrl('pages/products.php?category=Electronics') ?>">Electronics</a>
                    <a href="<?= baseUrl('pages/products.php?category=Fashion') ?>">Fashion</a>
                    <a href="<?= baseUrl('pages/products.php?category=Home') ?>">Home & Living</a>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <a href="<?= baseUrl('pages/login.php') ?>">Log in</a>
                    <a href="<?= baseUrl('pages/signup.php') ?>">Create Account</a>
                    <a href="<?= baseUrl('pages/cart.php') ?>">Cart</a>
                </div>
                <div class="footer-col">
                    <h4>Info</h4>
                    <a href="#">Shipping & Returns</a>
                    <a href="#">Contact</a>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?= date('Y') ?> ShopHub</span>
                <span>All rights reserved</span>
            </div>
        </div>
    </footer>

    <script src="<?= baseUrl('assets/js/app.js') ?>"></script>
</body>
</html>
