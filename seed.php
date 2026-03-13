<?php
/**
 * Database seeder — run once to populate demo data.
 * Usage: php seed.php  OR  visit http://localhost:8888/capi/shop/seed.php
 */
require_once __DIR__ . '/includes/db.php';

// Create demo seller accounts
$sellers = [
    ['name' => 'TechVault',   'email' => 'tech@demo.com',    'password' => 'password'],
    ['name' => 'StyleHouse',  'email' => 'style@demo.com',   'password' => 'password'],
    ['name' => 'HomeNest',    'email' => 'home@demo.com',    'password' => 'password'],
];

$sellerIds = [];
foreach ($sellers as $s) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$s['email']]);
    $existing = $stmt->fetchColumn();

    if ($existing) {
        $sellerIds[] = (int)$existing;
        continue;
    }

    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$s['name'], $s['email'], password_hash($s['password'], PASSWORD_DEFAULT)]);
    $sellerIds[] = (int)$pdo->lastInsertId();
}

// Demo products with public images from picsum.photos and placehold.co
$products = [
    // Electronics
    [
        'name' => 'Wireless Bluetooth Headphones',
        'description' => 'Premium over-ear wireless headphones with active noise cancellation, 30-hour battery life, and crystal-clear sound quality. Features Bluetooth 5.0 connectivity and comfortable memory foam ear cushions.',
        'price' => 79.99,
        'image_url' => 'https://picsum.photos/seed/headphones/600/400',
        'category' => 'Electronics',
        'stock' => 25,
        'seller' => 0,
    ],
    [
        'name' => 'Smart Watch Pro',
        'description' => 'Feature-packed smartwatch with heart rate monitor, GPS tracking, sleep analysis, and 7-day battery life. Water-resistant up to 50 meters with a vibrant AMOLED display.',
        'price' => 199.99,
        'image_url' => 'https://picsum.photos/seed/smartwatch/600/400',
        'category' => 'Electronics',
        'stock' => 15,
        'seller' => 0,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'description' => 'Compact waterproof speaker with 360-degree sound, 12-hour playtime, and built-in microphone for hands-free calls. Perfect for outdoor adventures.',
        'price' => 49.99,
        'image_url' => 'https://picsum.photos/seed/speaker/600/400',
        'category' => 'Electronics',
        'stock' => 40,
        'seller' => 0,
    ],
    [
        'name' => 'USB-C Charging Hub',
        'description' => '7-in-1 USB-C hub with HDMI output, SD card reader, USB 3.0 ports, and 100W power delivery. Compatible with all USB-C laptops and tablets.',
        'price' => 34.99,
        'image_url' => 'https://picsum.photos/seed/usbhub/600/400',
        'category' => 'Electronics',
        'stock' => 60,
        'seller' => 0,
    ],

    // Fashion
    [
        'name' => 'Classic Leather Jacket',
        'description' => 'Genuine leather biker jacket with quilted lining, multiple pockets, and heavy-duty zippers. A timeless wardrobe staple that gets better with age.',
        'price' => 149.99,
        'image_url' => 'https://picsum.photos/seed/leatherjacket/600/400',
        'category' => 'Fashion',
        'stock' => 10,
        'seller' => 1,
    ],
    [
        'name' => 'Canvas Sneakers',
        'description' => 'Lightweight canvas sneakers with cushioned insole and durable rubber outsole. Available in multiple colors for everyday comfort and style.',
        'price' => 44.99,
        'image_url' => 'https://picsum.photos/seed/sneakers/600/400',
        'category' => 'Fashion',
        'stock' => 50,
        'seller' => 1,
    ],
    [
        'name' => 'Aviator Sunglasses',
        'description' => 'Classic metal-frame aviator sunglasses with UV400 polarized lenses. Lightweight design with adjustable nose pads for a perfect fit.',
        'price' => 29.99,
        'image_url' => 'https://picsum.photos/seed/sunglasses/600/400',
        'category' => 'Fashion',
        'stock' => 35,
        'seller' => 1,
    ],
    [
        'name' => 'Wool Beanie Hat',
        'description' => 'Soft merino wool beanie with a classic ribbed knit pattern. Warm, breathable, and perfect for cold weather. One size fits most.',
        'price' => 19.99,
        'image_url' => 'https://picsum.photos/seed/beanie/600/400',
        'category' => 'Fashion',
        'stock' => 45,
        'seller' => 1,
    ],

    // Home
    [
        'name' => 'Ceramic Plant Pot Set',
        'description' => 'Set of 3 minimalist ceramic plant pots with drainage holes and bamboo saucers. Perfect for succulents, herbs, or small indoor plants.',
        'price' => 32.99,
        'image_url' => 'https://picsum.photos/seed/plantpots/600/400',
        'category' => 'Home',
        'stock' => 20,
        'seller' => 2,
    ],
    [
        'name' => 'Scented Soy Candle Collection',
        'description' => 'Hand-poured soy wax candles in 3 calming fragrances: lavender, vanilla, and sandalwood. Each burns for up to 45 hours.',
        'price' => 24.99,
        'image_url' => 'https://picsum.photos/seed/candles/600/400',
        'category' => 'Home',
        'stock' => 30,
        'seller' => 2,
    ],
    [
        'name' => 'Bamboo Desk Organizer',
        'description' => 'Multi-compartment bamboo desk organizer with phone stand, pen holder, and letter tray. Keep your workspace tidy and eco-friendly.',
        'price' => 27.99,
        'image_url' => 'https://picsum.photos/seed/deskorganizer/600/400',
        'category' => 'Home',
        'stock' => 18,
        'seller' => 2,
    ],
    [
        'name' => 'Throw Blanket — Herringbone',
        'description' => 'Ultra-soft cotton throw blanket in a classic herringbone pattern. Machine washable, perfect for the couch or bedroom. 50" x 60".',
        'price' => 39.99,
        'image_url' => 'https://picsum.photos/seed/blanket/600/400',
        'category' => 'Home',
        'stock' => 22,
        'seller' => 2,
    ],

    // Sports
    [
        'name' => 'Yoga Mat — Extra Thick',
        'description' => 'Premium 6mm thick yoga mat with non-slip texture on both sides. Includes carrying strap. Made from eco-friendly TPE material.',
        'price' => 29.99,
        'image_url' => 'https://picsum.photos/seed/yogamat/600/400',
        'category' => 'Sports',
        'stock' => 30,
        'seller' => 0,
    ],
    [
        'name' => 'Stainless Steel Water Bottle',
        'description' => 'Double-wall vacuum insulated water bottle. Keeps drinks cold for 24 hours or hot for 12 hours. BPA-free, 32oz capacity.',
        'price' => 22.99,
        'image_url' => 'https://picsum.photos/seed/waterbottle/600/400',
        'category' => 'Sports',
        'stock' => 55,
        'seller' => 0,
    ],
    [
        'name' => 'Resistance Bands Set',
        'description' => 'Set of 5 resistance bands with varying tension levels. Includes door anchor, ankle straps, and carrying bag. Perfect for home workouts.',
        'price' => 18.99,
        'image_url' => 'https://picsum.photos/seed/resistancebands/600/400',
        'category' => 'Sports',
        'stock' => 40,
        'seller' => 1,
    ],

    // Books
    [
        'name' => 'The Art of Clean Code',
        'description' => 'A comprehensive guide to writing maintainable, elegant code. Covers design patterns, refactoring techniques, and best practices used by top developers.',
        'price' => 24.99,
        'image_url' => 'https://picsum.photos/seed/codebook/600/400',
        'category' => 'Books',
        'stock' => 100,
        'seller' => 2,
    ],
    [
        'name' => 'Mindful Living Journal',
        'description' => 'Guided journal with daily prompts for gratitude, reflection, and goal setting. Beautifully designed with premium paper. 365 pages.',
        'price' => 16.99,
        'image_url' => 'https://picsum.photos/seed/journal/600/400',
        'category' => 'Books',
        'stock' => 70,
        'seller' => 2,
    ],

    // Beauty
    [
        'name' => 'Natural Skincare Gift Set',
        'description' => 'Luxurious skincare set with facial cleanser, toner, and moisturizer. Made with organic ingredients, free from parabens and sulfates.',
        'price' => 54.99,
        'image_url' => 'https://picsum.photos/seed/skincare/600/400',
        'category' => 'Beauty',
        'stock' => 20,
        'seller' => 1,
    ],
    [
        'name' => 'Bamboo Makeup Brush Set',
        'description' => '12-piece professional makeup brush set with sustainable bamboo handles and ultra-soft synthetic bristles. Comes in a roll-up travel case.',
        'price' => 26.99,
        'image_url' => 'https://picsum.photos/seed/makeupbrushes/600/400',
        'category' => 'Beauty',
        'stock' => 25,
        'seller' => 1,
    ],
];

$inserted = 0;
foreach ($products as $p) {
    // Check if product already exists
    $stmt = $pdo->prepare('SELECT id FROM products WHERE name = ?');
    $stmt->execute([$p['name']]);
    if ($stmt->fetch()) continue;

    $stmt = $pdo->prepare(
        'INSERT INTO products (user_id, name, description, price, image_url, category, stock) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $sellerIds[$p['seller']],
        $p['name'],
        $p['description'],
        $p['price'],
        $p['image_url'],
        $p['category'],
        $p['stock'],
    ]);
    $inserted++;
}

$message = "Seeding complete! Created " . count($sellerIds) . " seller accounts and inserted $inserted products.";

if (php_sapi_name() === 'cli') {
    echo $message . "\n";
    echo "Demo accounts (password: 'password'):\n";
    foreach ($sellers as $s) {
        echo "  - {$s['email']}\n";
    }
} else {
    echo '<!DOCTYPE html><html><head><title>Seed Complete</title>
    <style>body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;background:#f8fafc;}
    .card{background:white;padding:40px;border-radius:12px;box-shadow:0 4px 6px rgba(0,0,0,0.1);max-width:500px;text-align:center;}
    h1{color:#16a34a;margin-bottom:16px;}p{color:#475569;margin-bottom:8px;}
    a{display:inline-block;margin-top:20px;background:#2563eb;color:white;padding:10px 24px;border-radius:8px;text-decoration:none;}
    code{background:#f1f5f9;padding:2px 8px;border-radius:4px;font-size:0.9em;}</style></head>
    <body><div class="card"><h1>&#10003; Seed Complete</h1><p>' . htmlspecialchars($message) . '</p>
    <p style="margin-top:16px"><strong>Demo accounts</strong> (password: <code>password</code>):</p>';
    foreach ($sellers as $s) {
        echo '<p><code>' . htmlspecialchars($s['email']) . '</code></p>';
    }
    echo '<a href="/capi/shop/">Go to ShopHub</a></div></body></html>';
}
