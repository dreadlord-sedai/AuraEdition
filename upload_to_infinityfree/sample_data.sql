-- Sample data for AuraEdition database
-- Import this after importing auraedition_infinityfree.sql

-- First, clear any existing data to avoid conflicts
DELETE FROM `order_items`;
DELETE FROM `orders`;
DELETE FROM `cart_items`;
DELETE FROM `carts`;
DELETE FROM `wishlist_items`;
DELETE FROM `vehicle_images`;
DELETE FROM `vehicles`;
DELETE FROM `model`;
DELETE FROM `makes`;
DELETE FROM `user_addresses`;
DELETE FROM `users`;

-- Reset auto-increment counters
ALTER TABLE `order_items` AUTO_INCREMENT = 1;
ALTER TABLE `orders` AUTO_INCREMENT = 1;
ALTER TABLE `cart_items` AUTO_INCREMENT = 1;
ALTER TABLE `carts` AUTO_INCREMENT = 1;
ALTER TABLE `wishlist_items` AUTO_INCREMENT = 1;
ALTER TABLE `vehicle_images` AUTO_INCREMENT = 1;
ALTER TABLE `vehicles` AUTO_INCREMENT = 1;
ALTER TABLE `model` AUTO_INCREMENT = 1;
ALTER TABLE `makes` AUTO_INCREMENT = 1;
ALTER TABLE `user_addresses` AUTO_INCREMENT = 1;
ALTER TABLE `users` AUTO_INCREMENT = 1;

-- Insert sample makes (these will get IDs 1-12)
INSERT INTO `makes` (`make_name`, `make_image`) VALUES
('BMW', '/assets/images/make-1.png'),
('Mercedes-Benz', '/assets/images/make-2.jpg'),
('Audi', '/assets/images/make-3.png'),
('Lexus', '/assets/images/make-4.png'),
('Porsche', '/assets/images/make-5.png'),
('Ferrari', '/assets/images/make-6.png'),
('Lamborghini', '/assets/images/make-7.png'),
('Tesla', '/assets/images/make-8.png'),
('Bentley', '/assets/images/make-9.png'),
('Rolls-Royce', '/assets/images/make-10.png'),
('McLaren', '/assets/images/make-11.png'),
('Aston Martin', '/assets/images/make-12.png');

-- Insert sample models (using the correct make_id values)
INSERT INTO `model` (`model_name`, `model_make_id`) VALUES
-- BMW Models (make_id = 1)
('X5', 1),
('3 Series', 1),
('5 Series', 1),
('7 Series', 1),
-- Mercedes Models (make_id = 2)
('C-Class', 2),
('E-Class', 2),
('S-Class', 2),
('GLE', 2),
-- Audi Models (make_id = 3)
('A4', 3),
('A6', 3),
('Q5', 3),
('RS6', 3),
-- Lexus Models (make_id = 4)
('ES', 4),
('LS', 4),
('RX', 4),
-- Porsche Models (make_id = 5)
('911', 5),
('Cayenne', 5),
('Panamera', 5),
-- Ferrari Models (make_id = 6)
('F8', 6),
('SF90', 6),
('Roma', 6),
-- Lamborghini Models (make_id = 7)
('Huracan', 7),
('Aventador', 7),
('Urus', 7),
-- Tesla Models (make_id = 8)
('Model S', 8),
('Model 3', 8),
('Model X', 8),
-- Bentley Models (make_id = 9)
('Continental GT', 9),
('Bentayga', 9),
-- Rolls-Royce Models (make_id = 10)
('Phantom', 10),
('Cullinan', 10),
-- McLaren Models (make_id = 11)
('720S', 11),
('GT', 11),
-- Aston Martin Models (make_id = 12)
('DB11', 12),
('Vantage', 12);

-- Insert sample vehicles (using correct make_id and model_id values)
INSERT INTO `vehicles` (`title`, `price`, `make_id`, `model_id`, `description`, `stock`, `is_featured`, `is_popular`, `status`) VALUES
('2023 BMW X5 M Competition', 125000.00, 1, 1, 'Luxury SUV with M performance package, featuring a powerful V8 engine and premium interior.', 2, 1, 1, 'ACTIVE'),
('2023 Mercedes-Benz S-Class', 135000.00, 2, 7, 'Flagship luxury sedan with cutting-edge technology and unparalleled comfort.', 1, 1, 1, 'ACTIVE'),
('2023 Porsche 911 GT3 RS', 225000.00, 5, 16, 'Track-focused sports car with aerodynamic design and race-inspired performance.', 1, 1, 1, 'ACTIVE'),
('2023 Ferrari F8 Tributo', 275000.00, 6, 19, 'Mid-engine supercar with stunning design and incredible performance.', 1, 0, 1, 'ACTIVE'),
('2023 Lamborghini Huracan STO', 325000.00, 7, 22, 'Street-legal track car with aerodynamic efficiency and raw power.', 1, 0, 1, 'ACTIVE'),
('2023 Tesla Model S Plaid', 135000.00, 8, 25, 'Electric luxury sedan with insane acceleration and advanced autopilot.', 3, 0, 1, 'ACTIVE'),
('2023 Bentley Continental GT', 215000.00, 9, 28, 'Grand tourer combining luxury and performance in perfect harmony.', 2, 0, 0, 'ACTIVE'),
('2023 Rolls-Royce Phantom', 460000.00, 10, 30, 'Ultimate luxury sedan with bespoke craftsmanship and unmatched prestige.', 1, 0, 0, 'ACTIVE'),
('2023 McLaren 720S', 315000.00, 11, 32, 'Supercar with innovative aerodynamics and lightweight carbon fiber construction.', 1, 0, 0, 'ACTIVE'),
('2023 Aston Martin DB11', 205000.00, 12, 34, 'British grand tourer with elegant design and powerful performance.', 2, 0, 0, 'ACTIVE');

-- Insert sample vehicle images (using correct vehicle_id values)
INSERT INTO `vehicle_images` (`image_vehicle_id`, `image_path`, `is_primary`) VALUES
(1, '/products/img/product_1_685a2b04609959.52114874.jpg', 1),
(2, '/products/img/product_1_685a2b5db8bda7.38215088.jpg', 1),
(3, '/products/img/product_14_685a3792a1cae4.66015837.jpg', 1),
(4, '/products/img/product_7_685a2b8c9de972.36058457.jpg', 1),
(5, '/products/img/product1.jpg', 1),
(6, '/products/img/feature1.jpg', 1),
(7, '/products/img/feature2.jpg', 1),
(8, '/products/img/listings1.jpg', 1),
(9, '/products/img/makes1.jpg', 1),
(10, '/products/img/makes2.jpg', 1);

-- Insert admin user (password: admin123)
INSERT INTO `users` (`fname`, `lname`, `email`, `hashed_password`, `role`) VALUES
('Admin', 'User', 'admin@auraedition.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); 