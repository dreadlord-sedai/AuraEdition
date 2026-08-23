-- ===================================================================
-- AuraEdition demo seed data
--
-- Loads sample makes/models/vehicles/users/orders/carts/wishlist data
-- so every page renders with content.
--
-- Usage: mysql -u root -p < database/seed.sql   (after schema.sql)
--
-- Demo logins (passwords bcrypt-hashed, verifiable via password_verify):
--   admin@aura.com      / admin123     (role: admin)
--   demo@aura.com       / demo1234     (role: user, has address + cart)
--   james.carter@example.com / password123
--   sarah.nguyen@example.com / password123
--   mia.rodriguez@example.com / password123
-- ===================================================================

SET NAMES utf8mb4;
USE `auraedition`;
SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------------
-- Makes
-- -------------------------------------------------------------------
INSERT INTO `makes` (`make_id`, `make_name`, `make_image`) VALUES
(1, 'Ferrari',        '/Projects/AuraEdition/products/img/makes1.jpg'),
(2, 'Lamborghini',    '/Projects/AuraEdition/products/img/makes1.jpg'),
(3, 'Porsche',        '/Projects/AuraEdition/products/img/makes1.jpg'),
(4, 'McLaren',        '/Projects/AuraEdition/products/img/makes1.jpg'),
(5, 'Bentley',        '/Projects/AuraEdition/products/img/makes1.jpg'),
(6, 'Rolls-Royce',    '/Projects/AuraEdition/products/img/makes1.jpg'),
(7, 'Aston Martin',   '/Projects/AuraEdition/products/img/makes1.jpg'),
(8, 'Mercedes-Benz',  '/Projects/AuraEdition/products/img/makes1.jpg');

-- -------------------------------------------------------------------
-- Models
-- -------------------------------------------------------------------
INSERT INTO `model` (`model_id`, `model_name`, `model_make_id`) VALUES
(1,  'SF90 Stradale',   1),
(2,  'Roma',            1),
(3,  '296 GTB',         1),
(4,  'Huracan EVO',     2),
(5,  'Urus',            2),
(6,  '911 Carrera S',   3),
(7,  'Taycan Turbo',    3),
(8,  '720S',            4),
(9,  'Artura',          4),
(10, 'Continental GT',  5),
(11, 'Ghost',           6),
(12, 'Vantage',         7),
(13, 'AMG GT',          8),
(14, 'Bentayga',        5),
(15, 'Cullinan',        6);

-- -------------------------------------------------------------------
-- Vehicles  (ids 1..15; 3 featured, 4 popular, 1 inactive)
-- -------------------------------------------------------------------
INSERT INTO `vehicles`
(`id`, `title`, `price`, `make_id`, `model_id`, `description`, `stock`, `created_at`, `is_featured`, `is_popular`, `status`) VALUES
(1, '2021 Ferrari SF90 Stradale', 625000.00, 1, 1,
 'Hybrid hypercar with a 4.0L twin-turbo V8 and three electric motors producing a combined 986 hp. Nero Daytona over black leather, full carbon racing seats.', 2, '2026-06-15 10:00:00', 1, 0, 'ACTIVE'),
(2, '2022 Lamborghini Huracan EVO', 349000.00, 2, 4,
 'Naturally aspirated 5.2L V10 delivering 631 hp. RWD fun with rear-wheel steering. Blu Eleos metallic with alcantara interior.', 3, '2026-07-02 09:30:00', 1, 0, 'ACTIVE'),
(3, '2023 Porsche 911 Carrera S', 132500.00, 3, 6,
 'Twin-turbo flat-six, 443 hp, sport chrono package. GT Silver over Bordeaux red club interior. One owner, full service history.', 5, '2026-07-20 14:15:00', 1, 1, 'ACTIVE'),
(4, '2020 McLaren 720S Performance', 298000.00, 4, 8,
 'Carbon MonoCage tub, 710 hp twin-turbo V8, 0-60 in 2.8s. Volcano Yellow with stealth pack. Track telemetry included.', 1, '2026-05-28 11:45:00', 0, 1, 'ACTIVE'),
(5, '2023 Ferrari Roma', 246000.00, 1, 2,
 'La Nuova Dolce Vita. 612 hp twin-turbo V8 grand tourer in Rosso Corsa over crema leather with carbon fiber driver zone.', 2, '2026-04-10 15:20:00', 0, 0, 'ACTIVE'),
(6, '2022 Bentley Continental GT Speed', 274300.00, 5, 10,
 'W12 flagship grand tourer, 650 hp. Onyx black with linen hide and dark chrome spec. Rotating display, Naim audio.', 3, '2026-03-22 10:10:00', 0, 1, 'ACTIVE'),
(7, '2021 Porsche Taycan Turbo', 185400.00, 3, 7,
 'Electric performance at its finest: 680 hp overboost, 0-60 in 3.0s. Frozen Blue with premium package and performance battery.', 2, '2026-02-18 13:00:00', 0, 0, 'ACTIVE'),
(8, '2023 Aston Martin Vantage', 191000.00, 7, 12,
 '4.0L twin-turbo V8, 503 hp of British muscle. Xenon grey with obsidian black interior and sports exhaust.', 4, '2026-01-30 09:55:00', 0, 0, 'ACTIVE'),
(9, '2022 Rolls-Royce Ghost', 398500.00, 6, 11,
 'The pinnacle of luxury. 563 hp twin-turbo V12, starlight headliner, lambswool floor mats. Arctic white over seashell leather.', 1, '2025-12-12 12:30:00', 0, 1, 'ACTIVE'),
(10, '2023 Mercedes-Benz AMG GT 53', 118600.00, 8, 13,
 'AMG 4-door coupe with 429 hp inline-6 EQ Boost. Obsidian black with macchiato beige Nappa interior.', 6, '2025-11-05 16:40:00', 0, 0, 'ACTIVE'),
(11, '2022 Ferrari 296 GTB', 338000.00, 1, 3,
 'V6 hybrid berlinetta, 819 hp, 8300 rpm scream. Giallo Modena over nero. Assetto Fiorano options, lifter system.', 2, '2025-10-09 10:25:00', 0, 0, 'ACTIVE'),
(12, '2023 Lamborghini Urus', 241000.00, 2, 5,
 'Super SUV with 657 hp twin-turbo V8. Viola Pasifae with black 23-inch Taigete wheels and full ad personam interior.', 4, '2025-09-21 11:35:00', 0, 0, 'ACTIVE'),
(13, '2022 McLaren Artura', 249100.00, 4, 9,
 'High-performance hybrid: 671 hp twin-turbo V6 plus E-motor. Sarthe Grey with carbon fiber exterior upgrades.', 3, '2025-08-14 14:50:00', 0, 0, 'ACTIVE'),
(14, '2022 Bentley Bentayga V8', 229500.00, 5, 14,
 'Luxury SUV with 542 hp twin-turbo V8. Storm grey over beluga hide, touring specification, 22-inch wheels.', 2, '2025-07-19 09:15:00', 0, 0, 'ACTIVE'),
(15, '2023 Rolls-Royce Cullinan', 412800.00, 6, 15,
 'Effortless everywhere. 563 hp V12 SUV with viewing suite and recreation module. Sold pending collection.', 1, '2025-06-25 10:05:00', 0, 0, 'INACTIVE');

-- -------------------------------------------------------------------
-- Vehicle images (existing files under products/img/)
-- -------------------------------------------------------------------
INSERT INTO `vehicle_images` (`image_vehicle_id`, `image_path`, `is_primary`, `uploaded_at`) VALUES
(1,  '/Projects/AuraEdition/products/img/product_1_685a2b04609959.52114874.jpg', 1, NOW()),
(1,  '/Projects/AuraEdition/products/img/product_1_685a2b5db8bda7.38215088.jpg', 0, NOW()),
(2,  '/Projects/AuraEdition/products/img/feature1.jpg',    1, NOW()),
(3,  '/Projects/AuraEdition/products/img/listings1.jpg',   1, NOW()),
(4,  '/Projects/AuraEdition/products/img/feature2.jpg',    1, NOW()),
(5,  '/Projects/AuraEdition/products/img/product1.jpg',    1, NOW()),
(6,  '/Projects/AuraEdition/products/img/feature1.jpg',    1, NOW()),
(7,  '/Projects/AuraEdition/products/img/product_7_685a2b8c9de972.36058457.jpg', 1, NOW()),
(8,  '/Projects/AuraEdition/products/img/feature2.jpg',    1, NOW()),
(9,  '/Projects/AuraEdition/products/img/listings1.jpg',   1, NOW()),
(10, '/Projects/AuraEdition/products/img/product1.jpg',    1, NOW()),
(11, '/Projects/AuraEdition/products/img/feature1.jpg',    1, NOW()),
(12, '/Projects/AuraEdition/products/img/feature2.jpg',    1, NOW()),
(13, '/Projects/AuraEdition/products/img/listings1.jpg',   1, NOW()),
(14, '/Projects/AuraEdition/products/img/product_14_685a3792a1cae4.66015837.jpg', 1, NOW()),
(15, '/Projects/AuraEdition/products/img/feature2.jpg',    1, NOW());

-- -------------------------------------------------------------------
-- Users  (bcrypt hashes; see header for plaintext demo passwords)
-- -------------------------------------------------------------------
INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `hashed_password`, `role`, `registerd_date`) VALUES
(1, 'Aura',  'Admin',     'admin@aura.com',           '$2y$10$RCRk5rmg9G6Tbgu4t0fpAO1QCQrxG2upR4BbflHYQWgBqlOZdw6hy', 'admin', '2025-06-01 09:00:00'),
(2, 'Demo',  'Customer',  'demo@aura.com',            '$2y$10$BnK7vzt3jHofkKOh4B3XwuWF3Kj7/JJsJ.Ak.48r.uqQcYGgY1Bcm', 'user',  '2025-08-15 12:00:00'),
(3, 'James', 'Carter',    'james.carter@example.com', '$2y$10$mLDCeMPCmQ2A1yY6pT5M7OGHLlIzrAdIDBxZFS9xU0XaUuLXz2gk6', 'user',  '2025-10-03 18:20:00'),
(4, 'Sarah', 'Nguyen',    'sarah.nguyen@example.com', '$2y$10$mLDCeMPCmQ2A1yY6pT5M7OGHLlIzrAdIDBxZFS9xU0XaUuLXz2gk6', 'user',  '2026-01-11 08:45:00'),
(5, 'Mia',   'Rodriguez', 'mia.rodriguez@example.com','$2y$10$mLDCeMPCmQ2A1yY6pT5M7OGHLlIzrAdIDBxZFS9xU0XaUuLXz2gk6', 'user',  '2026-04-25 17:10:00');

-- -------------------------------------------------------------------
-- Addresses  (user 5 intentionally left without one)
-- -------------------------------------------------------------------
INSERT INTO `user_addresses` (`address_user_id`, `address`, `city`, `state`, `country`) VALUES
(2, '455 Ocean Drive',    'Miami Beach', 'Florida', 'United States'),
(3, '1200 Congress Ave',  'Austin',      'Texas',   'United States'),
(4, '88 Kings Road',      'London',      'Greater London', 'United Kingdom');

-- -------------------------------------------------------------------
-- Carts and cart items
-- -------------------------------------------------------------------
INSERT INTO `carts` (`cart_id`, `user_id`) VALUES
(1, 2),
(2, 3);

INSERT INTO `cart_items` (`cart_id`, `vehicle_id`, `quantity`) VALUES
(1, 2, 1),
(1, 7, 1),
(2, 1, 1);

-- -------------------------------------------------------------------
-- Orders and order items (spread over the last 12 months so the
-- admin dashboard sales chart and revenue figures have data)
-- -------------------------------------------------------------------
INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `orderd_at`) VALUES
(1, 3, 625000.00, 'delivered', '2025-09-10 14:32:00'),
(2, 2, 349000.00, 'delivered', '2025-11-04 10:15:00'),
(3, 4, 132500.00, 'shipped',   '2026-01-19 16:45:00'),
(4, 3, 572300.00, 'delivered', '2026-03-08 11:20:00'),
(5, 5, 185400.00, 'pending',   '2026-05-27 09:05:00'),
(6, 2, 398500.00, 'shipped',   '2026-06-30 13:40:00'),
(7, 4, 584000.00, 'delivered', '2026-07-16 17:55:00'),
(8, 3, 249100.00, 'pending',   '2026-08-12 12:10:00');

INSERT INTO `order_items` (`order_id`, `vehicle_id`, `quantity`, `price`) VALUES
(1, 1,  1, 625000.00),
(2, 2,  1, 349000.00),
(3, 3,  1, 132500.00),
(4, 4,  1, 298000.00),
(4, 6,  1, 274300.00),
(5, 7,  1, 185400.00),
(6, 9,  1, 398500.00),
(7, 11, 1, 338000.00),
(7, 5,  1, 246000.00),
(8, 13, 1, 249100.00);

-- -------------------------------------------------------------------
-- Wishlist items
-- -------------------------------------------------------------------
INSERT INTO `wishlist_items` (`user_id`, `vehicle_id`) VALUES
(2, 9),
(2, 4),
(3, 1),
(5, 3);

SET FOREIGN_KEY_CHECKS = 1;
