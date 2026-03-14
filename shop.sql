-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 13, 2026 at 09:40 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nowcodec_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','paid','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `stripe_session_id`, `status`, `created_at`) VALUES
(1, 4, 79.99, NULL, 'cancelled', '2026-03-13 21:26:48'),
(2, 4, 79.99, 'cs_test_a1xf8Zc0xYsPcdUBT1p7wCDw48lFrCUKSrcsJsURqZid2js3vNliemCbEP', 'paid', '2026-03-13 21:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 79.99),
(2, 2, 1, 1, 79.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `description`, `price`, `image_url`, `category`, `stock`, `created_at`) VALUES
(21, 5, 'Wireless Mouse', 'Give me a e-commerce description for a brown bag\r\n\r\n06:46\r\n\r\nRecognized straightforward product description task\r\nRecognized straightforward product description task\r\nClassic Brown Bag — Timeless Style, Everyday Versatility\r\nEffortlessly chic and endlessly practical, this Classic Brown Bag is the everyday essential your wardrobe has been waiting for. Crafted in rich, warm-toned brown, it pairs seamlessly with any outfit — from casual weekend looks to polished office ensembles.\r\n\r\nKey Features:\r\n\r\nPremium Material — Made from durable, high-quality fabric with a smooth, refined finish that resists everyday wear and tear.\r\nSpacious Interior — Thoughtfully designed with ample room to carry your daily essentials — wallet, keys, phone, and more — without the bulk.\r\nSecure Closure — Features a sturdy zip or snap closure to keep your belongings safe on the go.\r\nComfortable Carry — Ergonomically designed straps ensure a comfortable fit whether worn on the shoulder or carried by hand.\r\nVersatile Design — A clean, minimalist silhouette that transitions effortlessly from day to night, work to weekend.\r\nWhy You\'ll Love It: Brown is the new neutral. Warm, grounded, and incredibly easy to style, this bag adds a touch of earthy sophistication to any look without trying too hard.\r\n\r\nAvailable in multiple sizes. Limited stock — order yours today!\r\n\r\nWant me to tailor this for a specific type of bag (handbag, tote, backpack, paper bag, etc.) or a particular platform like Shopify, Amazon, or Etsy?\r\n\r\nAs if I am adding it to my site\r\n\r\n06:46\r\n\r\nArchitected polished e-commerce product description for website integration\r\nArchitected polished e-commerce product description for website integration\r\nHere\'s a clean, web-ready product description you can drop straight into your site:\r\n\r\nClassic Brown Bag\r\n\r\nMeet your new everyday essential. This classic brown bag blends timeless style with practical design, making it the perfect companion for wherever your day takes you.\r\n\r\nBuilt to last and styled to impress, the warm brown finish pairs effortlessly with any outfit — dress it up, dress it down, it always delivers.\r\n\r\nWhat\'s included:\r\n\r\nSpacious main compartment for all your daily essentials\r\nSecure zip closure to keep everything in place\r\nComfortable carry straps for all-day ease\r\nDurable construction built for everyday use\r\nSleek, minimalist design that never goes out of style\r\nWhether you\'re heading to work, running errands, or meeting friends, this bag has you covered — in style.\r\n\r\n🛒 Add to Cart and elevate your everyday carry.\r\n\r\nWant me to also write a short meta description for SEO, or a product title tag to go along with it?\r\n\r\nYes\r\n\r\n06:46\r\n\r\nIdentified additional metadata requirements for optimization\r\nIdentified additional metadata requirements for optimization\r\nHere you go — everything you need for the product page:\r\n\r\nProduct Title Tag\r\n\r\nClassic Brown Bag | Everyday Style & Durability | [Your Store Name]\r\nMeta Description\r\n\r\nShop the Classic Brown Bag — a timeless, versatile everyday bag built for style and durability. Perfect for work, errands, and everything in between. Order yours today.\r\nQuick tips for your site:\r\n\r\nKeep your title tag under 60 characters (excluding your store name) so it doesn\'t get cut off in search results.\r\nThe meta description is already optimized at under 160 characters — the sweet spot for Google.\r\nSwap in specific material details (e.g., genuine leather, canvas) if applicable, to boost search relevance.\r\nWant me to also write product image alt text or a short social media caption to promote it?\r\n\r\nOk do for gadget\r\n\r\n06:47\r\n\r\nOrchestrated unified marketing content for gadget product\r\nOrchestrated unified marketing content for gadget product\r\nHere\'s the full set for a gadget product page:\r\n\r\nProduct Description\r\n\r\nThe Gadget\r\n\r\nThe future is here — and it fits right in your hands. This sleek, cutting-edge gadget is designed for those who demand performance, precision, and style all in one device.\r\n\r\nEngineered with the latest technology and built for real-world use, it does more so you can stress less.\r\n\r\nWhat you get:\r\n\r\nHigh-performance functionality built for everyday demands\r\nCompact, lightweight design that goes anywhere you do\r\nIntuitive controls for a seamless user experience\r\nLong-lasting battery life to keep you powered all day\r\nDurable build quality that stands up to daily use\r\nWhether you\'re a tech enthusiast or just love smart solutions, this gadget will quickly become something you can\'t live without.\r\n\r\n🛒 Add to Cart and upgrade your everyday life.\r\n\r\nProduct Title Tag\r\n\r\nSmart Gadget | High-Performance & Sleek Design | [Your Store Name]\r\nMeta Description\r\n\r\nDiscover our premium Smart Gadget — powerful, compact, and built for everyday use. Experience next-level performance and sleek design. Shop now and upgrade today.\r\nWant me to tailor this further to a specific gadget — like earbuds, a smartwatch, a power bank, or a phone accessory? The more specific, the better it converts!\r\n\r\nI mean list 6 computer gadget and do for it\r\n\r\n06:48\r\n\r\nDeciphered request to catalog gadgets with marketing content\r\nDeciphered request to catalog gadgets with marketing content\r\nHere are 6 computer gadgets with full product page copy for each:\r\n\r\n1. 🖱️ Wireless Mouse\r\nProduct Description Say goodbye to tangled cables. This wireless mouse delivers smooth, precise tracking with a comfortable ergonomic grip — perfect for long work sessions or casual browsing.\r\n\r\nLag-free wireless connectivity up to 10 metres\r\nErgonomic design for all-day comfort\r\nLong battery life with auto-sleep mode\r\nPlug-and-play USB receiver — no setup needed\r\nSilent click technology for quiet environments\r\n🛒 Add to Cart and cut the cord for good.', 2.00, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800', 'Electronics', 10, '2026-03-14 06:06:12'),
(22, 5, 'Mechanical Keyboard', 'Give me a e-commerce description for a brown bag\r\n\r\n06:46\r\n\r\nRecognized straightforward product description task\r\nRecognized straightforward product description task\r\nClassic Brown Bag — Timeless Style, Everyday Versatility\r\nEffortlessly chic and endlessly practical, this Classic Brown Bag is the everyday essential your wardrobe has been waiting for. Crafted in rich, warm-toned brown, it pairs seamlessly with any outfit — from casual weekend looks to polished office ensembles.\r\n\r\nKey Features:\r\n\r\nPremium Material — Made from durable, high-quality fabric with a smooth, refined finish that resists everyday wear and tear.\r\nSpacious Interior — Thoughtfully designed with ample room to carry your daily essentials — wallet, keys, phone, and more — without the bulk.\r\nSecure Closure — Features a sturdy zip or snap closure to keep your belongings safe on the go.\r\nComfortable Carry — Ergonomically designed straps ensure a comfortable fit whether worn on the shoulder or carried by hand.\r\nVersatile Design — A clean, minimalist silhouette that transitions effortlessly from day to night, work to weekend.\r\nWhy You\'ll Love It: Brown is the new neutral. Warm, grounded, and incredibly easy to style, this bag adds a touch of earthy sophistication to any look without trying too hard.\r\n\r\nAvailable in multiple sizes. Limited stock — order yours today!\r\n\r\nWant me to tailor this for a specific type of bag (handbag, tote, backpack, paper bag, etc.) or a particular platform like Shopify, Amazon, or Etsy?\r\n\r\nAs if I am adding it to my site\r\n\r\n06:46\r\n\r\nArchitected polished e-commerce product description for website integration\r\nArchitected polished e-commerce product description for website integration\r\nHere\'s a clean, web-ready product description you can drop straight into your site:\r\n\r\nClassic Brown Bag\r\n\r\nMeet your new everyday essential. This classic brown bag blends timeless style with practical design, making it the perfect companion for wherever your day takes you.\r\n\r\nBuilt to last and styled to impress, the warm brown finish pairs effortlessly with any outfit — dress it up, dress it down, it always delivers.\r\n\r\nWhat\'s included:\r\n\r\nSpacious main compartment for all your daily essentials\r\nSecure zip closure to keep everything in place\r\nComfortable carry straps for all-day ease\r\nDurable construction built for everyday use\r\nSleek, minimalist design that never goes out of style\r\nWhether you\'re heading to work, running errands, or meeting friends, this bag has you covered — in style.\r\n\r\n🛒 Add to Cart and elevate your everyday carry.\r\n\r\nWant me to also write a short meta description for SEO, or a product title tag to go along with it?\r\n\r\nYes\r\n\r\n06:46\r\n\r\nIdentified additional metadata requirements for optimization\r\nIdentified additional metadata requirements for optimization\r\nHere you go — everything you need for the product page:\r\n\r\nProduct Title Tag\r\n\r\nClassic Brown Bag | Everyday Style & Durability | [Your Store Name]\r\nMeta Description\r\n\r\nShop the Classic Brown Bag — a timeless, versatile everyday bag built for style and durability. Perfect for work, errands, and everything in between. Order yours today.\r\nQuick tips for your site:\r\n\r\nKeep your title tag under 60 characters (excluding your store name) so it doesn\'t get cut off in search results.\r\nThe meta description is already optimized at under 160 characters — the sweet spot for Google.\r\nSwap in specific material details (e.g., genuine leather, canvas) if applicable, to boost search relevance.\r\nWant me to also write product image alt text or a short social media caption to promote it?\r\n\r\nOk do for gadget\r\n\r\n06:47\r\n\r\nOrchestrated unified marketing content for gadget product\r\nOrchestrated unified marketing content for gadget product\r\nHere\'s the full set for a gadget product page:\r\n\r\nProduct Description\r\n\r\nThe Gadget\r\n\r\nThe future is here — and it fits right in your hands. This sleek, cutting-edge gadget is designed for those who demand performance, precision, and style all in one device.\r\n\r\nEngineered with the latest technology and built for real-world use, it does more so you can stress less.\r\n\r\nWhat you get:\r\n\r\nHigh-performance functionality built for everyday demands\r\nCompact, lightweight design that goes anywhere you do\r\nIntuitive controls for a seamless user experience\r\nLong-lasting battery life to keep you powered all day\r\nDurable build quality that stands up to daily use\r\nWhether you\'re a tech enthusiast or just love smart solutions, this gadget will quickly become something you can\'t live without.\r\n\r\n🛒 Add to Cart and upgrade your everyday life.\r\n\r\nProduct Title Tag\r\n\r\nSmart Gadget | High-Performance & Sleek Design | [Your Store Name]\r\nMeta Description\r\n\r\nDiscover our premium Smart Gadget — powerful, compact, and built for everyday use. Experience next-level performance and sleek design. Shop now and upgrade today.\r\nWant me to tailor this further to a specific gadget — like earbuds, a smartwatch, a power bank, or a phone accessory? The more specific, the better it converts!\r\n\r\nI mean list 6 computer gadget and do for it\r\n\r\n06:48\r\n\r\nDeciphered request to catalog gadgets with marketing content\r\nDeciphered request to catalog gadgets with marketing content\r\nHere are 6 computer gadgets with full product page copy for each:\r\n\r\n1. 🖱️ Wireless Mouse\r\nProduct Description Say goodbye to tangled cables. This wireless mouse delivers smooth, precise tracking with a comfortable ergonomic grip — perfect for long work sessions or casual browsing.\r\n\r\nLag-free wireless connectivity up to 10 metres\r\nErgonomic design for all-day comfort\r\nLong battery life with auto-sleep mode\r\nPlug-and-play USB receiver — no setup needed\r\nSilent click technology for quiet environments\r\n🛒 Add to Cart and cut the cord for good.\r\n\r\nTitle Tag\r\n\r\nWireless Mouse | Ergonomic & Lag-Free | [Your Store Name]\r\nMeta Description\r\n\r\nShop our Wireless Mouse — ergonomic, precise, and cable-free. Perfect for work or home use. Plug in and get going. Order yours today.\r\n2. ⌨️ Mechanical Keyboard\r\nProduct Description Type faster, feel every keystroke, and never look back. This mechanical keyboard is built for typists, gamers, and professionals who refuse to compromise on feel and performance.\r\n\r\nTactile mechanical switches for satisfying feedback\r\nRGB backlit keys for style and low-light use\r\nDurable aluminium frame built to last\r\nAnti-ghosting technology for flawless multi-key input\r\nCompatible with Windows and Mac\r\n🛒 Add to Cart and transform the way you type.', 3.00, 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?w=800', 'Electronics', 5, '2026-03-14 06:09:33'),
(23, 5, 'USB Headset', 'Hear everything, miss nothing. This USB headset delivers crystal-clear audio and a noise-cancelling microphone — built for meetings, gaming, and everything in between.\r\n\r\nNoise-cancelling mic for clear, professional calls\r\nRich stereo sound for immersive audio\r\nSoft padded ear cups for extended wear\r\nPlug-and-play USB connectivity\r\nAdjustable headband for a perfect fit\r\n\r\n🛒 Add to Cart and never miss a word again.', 5.00, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800', 'Electronics', 25, '2026-03-14 06:12:34'),
(24, 5, 'LED Monitor Light Bar', 'Brighten your workspace without brightening your screen. This sleek LED monitor light bar sits right on top of your monitor, reducing eye strain and boosting your focus — no glare, no shadows.\r\n\r\nAnti-glare design that won\'t reflect on your screen\r\nAdjustable colour temperature — warm to cool white\r\nTouch-sensitive dimmer control\r\nUSB powered — no extra cables or outlets needed\r\nFits most monitors without clips or tools\r\n\r\n🛒 Add to Cart and light up your productivity.', 2.00, 'https://images.unsplash.com/photo-1598550476439-6847785fcea6?w=800', 'Electronics', 15, '2026-03-14 06:18:39'),
(25, 6, 'USB Flash Drive', 'Store it, carry it, share it — instantly. This compact USB flash drive gives you fast, reliable storage that fits in your pocket and works on any device.\r\n\r\nHigh-speed USB 3.0 transfer — move files in seconds\r\nCompact plug-and-play design, no software needed\r\nDurable casing built to handle everyday wear\r\nAvailable in multiple storage sizes\r\nCompatible with Windows, Mac, and Linux\r\n\r\n🛒 Add to Cart and carry your world in your pocket.', 5.00, 'https://media.istockphoto.com/id/476801528/photo/black-foading-thumb-drive-with-clipping-path.webp?s=2048x2048&w=is&k=20&c=Trm93Zbhh5C3yApRk6N1vJNMISmAInTrgtZOo7pOAaw=', 'Electronics', 25, '2026-03-14 06:44:58'),
(26, 6, 'Laptop Desk Stand', 'Work smarter, sit better. This sleek laptop desk stand raises your screen to eye level, reducing neck strain and transforming any space into a productive workstation.\r\n\r\nAdjustable height and angle for perfect ergonomics\r\nFoldable, lightweight design — ideal for travel\r\nNon-slip pads to keep your laptop secure\r\nOpen ventilation design prevents overheating\r\nFits laptops from 10 to 17 inches\r\nCompatible with MacBook, Dell, HP, Lenovo, and more', 15.00, 'https://plus.unsplash.com/premium_photo-1683736986821-e4662912a70d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8TGFwdG9wJTIwRGVzayUyMFN0YW5kfGVufDB8fDB8fHww', 'Other', 10, '2026-03-14 06:46:41'),
(27, 6, 'Bluetooth Speaker', 'A portable speaker that connects wirelessly to smartphones and laptops to play music anywhere.', 35.00, 'https://images.unsplash.com/photo-1547052178-7f2c5a20c332?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fEJMVUVUT09USCUyMFNQRUFLRVJ8ZW58MHx8MHx8fDA%3D', 'Electronics', 10, '2026-03-14 06:50:43'),
(28, 6, 'Power Bank (20,000mAh)', 'A high-capacity portable charger that keeps your phone powered when you are on the move.', 14.00, 'https://media.istockphoto.com/id/1409737619/photo/a-mobile-phone-being-charged-using-a-power-bank-is-on-the-table.jpg?s=612x612&w=0&k=20&c=Z8T2cLqSCItTo3UwbeL-Lx8N4gyjMH7QUvxd_XVuQlU=', 'Electronics', 15, '2026-03-14 06:53:02'),
(29, 6, 'Ring Light', 'A bright LED ring light used for selfies, videos, and professional lighting.', 24.00, 'https://plus.unsplash.com/premium_photo-1684611913202-479ff05703da?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cmluZyUyMGxpZ2h0fGVufDB8fDB8fHww', 'Electronics', 5, '2026-03-14 06:56:23'),
(30, 6, 'Gaming Headset', 'High-quality headphones with a microphone designed for gaming and clear communication.', 6.00, 'https://images.unsplash.com/photo-1629429407756-4a7703614972?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Z2FtaW5nJTIwaGVhZHNldHxlbnwwfHwwfHx8MA%3D%3D', 'Electronics', 6, '2026-03-14 06:58:10'),
(31, 6, 'Portable Mini Fan', 'A small rechargeable fan that helps keep you cool during hot weather.', 4.00, 'https://media.istockphoto.com/id/1387838780/photo/close-up-apricot-colored-portable-mini-fans.jpg?s=612x612&w=0&k=20&c=9LHkuqy9AsDkkUNLYFpURU5Vz3ADh-yvT5yaF3Vbtgc=', 'Electronics', 12, '2026-03-14 07:01:00'),
(32, 6, 'Webcam', 'A camera used for video calls, online classes, streaming, and meetings.', 5.00, 'https://images.unsplash.com/photo-1614588876378-b2ffa4520c22?q=80&w=1160&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Electronics', 23, '2026-03-14 07:06:08'),
(33, 6, 'Women’s Handbag', 'A stylish handbag designed to carry essentials while complementing your outfit.', 54.00, 'https://plus.unsplash.com/premium_photo-1664392147011-2a720f214e01?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d29tZW4lMjBoYW5kYmFnfGVufDB8fDB8fHww', 'Fashion', 5, '2026-03-14 07:09:44'),
(34, 6, 'Denim Jeans', 'Durable and fashionable jeans suitable for both casual and semi-casual wear.', 28.90, 'https://images.unsplash.com/photo-1714143136372-ddaf8b606da7?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8ZGVuaW0lMjBqZWFuc3xlbnwwfHwwfHx8MA%3D%3D', 'Fashion', 14, '2026-03-14 07:11:02'),
(35, 6, 'Wall Clock', 'A decorative clock used to keep track of time and beautify walls.', 34.00, 'https://plus.unsplash.com/premium_photo-1725075084045-4c1ee2ab9349?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8d2FsbCUyMGNsb2NrfGVufDB8fDB8fHww', 'Home', 4, '2026-03-14 07:13:05'),
(36, 6, 'Bookshelf', 'A storage shelf used for organizing books, decorations, and other items.', 60.00, 'https://images.unsplash.com/photo-1543248939-4296e1fea89b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Ym9va3NoZWxmfGVufDB8fDB8fHww', 'Home', 5, '2026-03-14 07:14:25'),
(37, 6, 'Kitchen Blender', 'A kitchen appliance used to blend fruits, vegetables, and ingredients for smoothies or cooking.', 15.00, 'https://plus.unsplash.com/premium_photo-1718043036199-d98bef36af46?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YmxlbmRlcnxlbnwwfHwwfHx8MA%3D%3D', 'Home', 5, '2026-03-14 07:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'TechVault', 'tech@demo.com', '$2y$10$48yNrJGRVcAVkxiOedwdYeAra3njYa0ZpFsNVtmiJRVlb8auI8Jp6', '2026-03-13 20:58:31'),
(2, 'StyleHouse', 'style@demo.com', '$2y$10$D0CLAbM84qj8RMVFkwBrlOIPBcbxg0GM0BeG4Ps65nsZTtsdW/uSC', '2026-03-13 20:58:31'),
(3, 'HomeNest', 'home@demo.com', '$2y$10$TQBFvJR38Oteu55bxNTOBO7soaGYq/5COWdmfnNMLZB0ttcNoGFLK', '2026-03-13 20:58:32'),
(4, 'test', 'ajajaolamilekan7@gmail.com', '$2y$10$YWApA2k06RhOmMLrerlCx.VvCCrwR60/kg7096ZUxzbbPsG8JYWGa', '2026-03-13 21:26:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
