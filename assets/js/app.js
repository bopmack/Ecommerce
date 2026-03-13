document.addEventListener('DOMContentLoaded', function () {

    // ===== Theme Toggle =====
    var toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme');
            var isDark = current === 'dark';

            // If no explicit theme set, check system preference
            if (!current) {
                isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            var next = isDark ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }

    // ===== Mobile Nav =====
    var mobileToggle = document.querySelector('.mobile-toggle');
    var navLinks = document.querySelector('.nav-links');

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function () {
            navLinks.classList.toggle('active');
        });
    }

    // ===== Image Preview =====
    var imageUrlInput = document.getElementById('image_url');
    var imagePreview = document.getElementById('imagePreview');

    if (imageUrlInput && imagePreview) {
        imageUrlInput.addEventListener('input', function () {
            var url = this.value.trim();
            if (url) {
                imagePreview.innerHTML = '<img src="' + url + '" alt="Preview" onerror="this.parentElement.innerHTML=\'Invalid image URL\'">';
            } else {
                imagePreview.innerHTML = 'Image preview';
            }
        });
    }

    // ===== Flash auto-dismiss =====
    var flash = document.querySelector('.flash');
    if (flash) {
        setTimeout(function () {
            flash.style.transition = 'opacity 0.4s';
            flash.style.opacity = '0';
            setTimeout(function () { flash.remove(); }, 400);
        }, 3500);
    }
});
