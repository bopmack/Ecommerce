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
(1, 1, 'Wireless Bluetooth Headphones', 'Premium over-ear wireless headphones with active noise cancellation, 30-hour battery life, and crystal-clear sound quality. Features Bluetooth 5.0 connectivity and comfortable memory foam ear cushions.', 79.99, 'https://picsum.photos/seed/headphones/600/400', 'Electronics', 23, '2026-03-13 20:58:32'),
(2, 1, 'Smart Watch Pro', 'Feature-packed smartwatch with heart rate monitor, GPS tracking, sleep analysis, and 7-day battery life. Water-resistant up to 50 meters with a vibrant AMOLED display.', 199.99, 'https://picsum.photos/seed/smartwatch/600/400', 'Electronics', 15, '2026-03-13 20:58:32'),
(3, 1, 'Portable Bluetooth Speaker', 'Compact waterproof speaker with 360-degree sound, 12-hour playtime, and built-in microphone for hands-free calls. Perfect for outdoor adventures.', 49.99, 'https://picsum.photos/seed/speaker/600/400', 'Electronics', 40, '2026-03-13 20:58:32'),
(4, 1, 'USB-C Charging Hub', '7-in-1 USB-C hub with HDMI output, SD card reader, USB 3.0 ports, and 100W power delivery. Compatible with all USB-C laptops and tablets.', 34.99, 'https://picsum.photos/seed/usbhub/600/400', 'Electronics', 60, '2026-03-13 20:58:32'),
(5, 2, 'Classic Leather Jacket', 'Genuine leather biker jacket with quilted lining, multiple pockets, and heavy-duty zippers. A timeless wardrobe staple that gets better with age.', 149.99, 'https://picsum.photos/seed/leatherjacket/600/400', 'Fashion', 10, '2026-03-13 20:58:32'),
(6, 2, 'Canvas Sneakers', 'Lightweight canvas sneakers with cushioned insole and durable rubber outsole. Available in multiple colors for everyday comfort and style.', 44.99, 'https://picsum.photos/seed/sneakers/600/400', 'Fashion', 50, '2026-03-13 20:58:32'),
(7, 2, 'Aviator Sunglasses', 'Classic metal-frame aviator sunglasses with UV400 polarized lenses. Lightweight design with adjustable nose pads for a perfect fit.', 29.99, 'https://picsum.photos/seed/sunglasses/600/400', 'Fashion', 35, '2026-03-13 20:58:32'),
(8, 2, 'Wool Beanie Hat', 'Soft merino wool beanie with a classic ribbed knit pattern. Warm, breathable, and perfect for cold weather. One size fits most.', 19.99, 'https://picsum.photos/seed/beanie/600/400', 'Fashion', 45, '2026-03-13 20:58:32'),
(9, 3, 'Ceramic Plant Pot Set', 'Set of 3 minimalist ceramic plant pots with drainage holes and bamboo saucers. Perfect for succulents, herbs, or small indoor plants.', 32.99, 'https://picsum.photos/seed/plantpots/600/400', 'Home', 20, '2026-03-13 20:58:32'),
(10, 3, 'Scented Soy Candle Collection', 'Hand-poured soy wax candles in 3 calming fragrances: lavender, vanilla, and sandalwood. Each burns for up to 45 hours.', 24.99, 'https://picsum.photos/seed/candles/600/400', 'Home', 30, '2026-03-13 20:58:32'),
(11, 3, 'Bamboo Desk Organizer', 'Multi-compartment bamboo desk organizer with phone stand, pen holder, and letter tray. Keep your workspace tidy and eco-friendly.', 27.99, 'https://picsum.photos/seed/deskorganizer/600/400', 'Home', 18, '2026-03-13 20:58:32'),
(12, 3, 'Throw Blanket — Herringbone', 'Ultra-soft cotton throw blanket in a classic herringbone pattern. Machine washable, perfect for the couch or bedroom. 50\" x 60\".', 39.99, 'https://picsum.photos/seed/blanket/600/400', 'Home', 22, '2026-03-13 20:58:32'),
(13, 1, 'Yoga Mat — Extra Thick', 'Premium 6mm thick yoga mat with non-slip texture on both sides. Includes carrying strap. Made from eco-friendly TPE material.', 29.99, 'https://picsum.photos/seed/yogamat/600/400', 'Sports', 30, '2026-03-13 20:58:32'),
(14, 1, 'Stainless Steel Water Bottle', 'Double-wall vacuum insulated water bottle. Keeps drinks cold for 24 hours or hot for 12 hours. BPA-free, 32oz capacity.', 22.99, 'https://picsum.photos/seed/waterbottle/600/400', 'Sports', 55, '2026-03-13 20:58:32'),
(15, 2, 'Resistance Bands Set', 'Set of 5 resistance bands with varying tension levels. Includes door anchor, ankle straps, and carrying bag. Perfect for home workouts.', 18.99, 'https://picsum.photos/seed/resistancebands/600/400', 'Sports', 40, '2026-03-13 20:58:32'),
(16, 3, 'The Art of Clean Code', 'A comprehensive guide to writing maintainable, elegant code. Covers design patterns, refactoring techniques, and best practices used by top developers.', 24.99, 'https://picsum.photos/seed/codebook/600/400', 'Books', 100, '2026-03-13 20:58:32'),
(17, 3, 'Mindful Living Journal', 'Guided journal with daily prompts for gratitude, reflection, and goal setting. Beautifully designed with premium paper. 365 pages.', 16.99, 'https://picsum.photos/seed/journal/600/400', 'Books', 70, '2026-03-13 20:58:32'),
(18, 2, 'Natural Skincare Gift Set', 'Luxurious skincare set with facial cleanser, toner, and moisturizer. Made with organic ingredients, free from parabens and sulfates.', 54.99, 'https://picsum.photos/seed/skincare/600/400', 'Beauty', 20, '2026-03-13 20:58:32'),
(19, 2, 'Bamboo Makeup Brush Set', '12-piece professional makeup brush set with sustainable bamboo handles and ultra-soft synthetic bristles. Comes in a roll-up travel case.', 26.99, 'https://picsum.photos/seed/makeupbrushes/600/400', 'Beauty', 25, '2026-03-13 20:58:32');

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
