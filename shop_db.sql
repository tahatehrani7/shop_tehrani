-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 10:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'Ali Reza', 'ali@example.com', 'hashed_password_1', '09123456789', '2025-02-10 08:47:11'),
(2, 'Sara Mohammad', 'sara@example.com', 'hashed_password_2', '09129876543', '2025-02-10 08:47:11'),
(3, 'Mohammad Reza', 'mohammad@example.com', 'hashed_password_3', '09137654321', '2025-02-10 08:47:11'),
(4, 'admin', 'admin@example.com', 'adminpass', '1234567890', '2025-02-10 09:13:14'),
(5, 'user1', 'user1@example.com', 'user1pass', '1234567891', '2025-02-10 09:13:14'),
(6, 'user2', 'user2@example.com', 'user2pass', '1234567892', '2025-02-10 09:13:14'),
(7, 'user3', 'user3@example.com', 'user3pass', '1234567893', '2025-02-10 09:13:14'),
(10, 'مهدی طهرانی', 'mt12310@gmail.com', '$2y$10$8N5sOv71rchunKFlGraE2.pjwMPggs689Ds7rx2/EfSSsQ3wUg87K', '099120992353', '2025-02-10 10:26:14'),
(13, 'طاها طهرانی', 'tahathrany7@gmail.com', '$2y$10$MXvYCrE.tpr5VdtswGfp.ePqHaTj/oWQ4JWX4dJCax11zK2EXKjvS', '09915115736', '2025-02-10 15:15:20'),
(14, 'ahmad', 'ahmad@gmail.com', '$2y$10$gw4Vpi1ddFyTVS3jb8Ze8OUUG3TFtC4FR5xY42M61QUdFBZ2O47yy', '09914582478', '2025-02-14 17:50:27'),
(15, 'amir ghormesabzi', 'gormesabzi@gmail', '$2y$10$iIgBn0J8TOQe.da9zM04puNVWhNi7jXjAT2QlCxjjkiLGNYxAxYf6', '09134567845', '2025-04-14 05:07:59'),
(16, 'tehrani', 'tahatehrani@gamil.com', '$2y$10$fidcEOSW0jMDVJGqAbbDlutTZtJO3wmRbNBtUjVMTGGanGiw1RKNO', '09915115736', '2025-04-14 06:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `orders_table`
--

CREATE TABLE `orders_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiration` varchar(5) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `price` int(11) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_number` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_table`
--

INSERT INTO `orders_table` (`id`, `name`, `card_number`, `expiration`, `cvv`, `price`, `address`, `created_at`, `order_number`, `status`) VALUES
(13, 'NBA 2K25 swith', '9789784545645645', '06/04', '6666', 5020, 'خیابان بزرگمهر جنب کوچه علی بابا', '2025-04-14 08:45:30', '0998768345 ', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `product_price`, `quantity`, `total_price`) VALUES
(31, 13, ' game pass 1 month home ', 310, 2, 620),
(32, 13, 'Ubisoft 1years home', 3840, 1, 3840),
(33, 13, ' game pass 1 month swith', 280, 2, 560);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, ' game pass 1 month home ', 'اشتراک گیم پس 1 ماهه به صورت هوم هست که قابل استفاده به صورت هم افلاین هم انلاین روی اکانت خود هستید .\r\nاشتراک گیم پس با دسترسی به بیش از 1000 تا بازی هست که بازی هایی مثل call of duty از همان روز عرضه جهانی روی سرور قرار گرفته میشود.', 310.00, 'product_1.png'),
(2, ' game pass 1 month swith', 'اشتراک گیم پس 1 ماهه به صورت سویچ هست که قابل استفاده به صورت انلاین روی اکانت خود هستید . اشتراک گیم پس با دسترسی به بیش از 1000 تا بازی هست که بازی هایی مثل call of duty از همان روز عرضه جهانی روی سرور قرار گرفته میشود.', 280.00, 'product_2.png'),
(3, 'Ubisoft 1years home', 'به صورت هوم روی اکانت خود بازی میکنید هم به صورت افلاین و هم انلاین .\r\nدسترسی کامل به تمام بازی های شرکت بزرگ یوبیسافت به ادیشن کامل با تمام اسکین ها و تمام مراحل فرعی بازی.', 3840.00, 'product_3.png'),
(4, 'Ubisoft 1years swith', 'به صورت هوم روی اکانت خود بازی میکنید به صورت انلاین .\r\nدسترسی کامل به تمام بازی های شرکت بزرگ یوبیسافت به ادیشن کامل با تمام اسکین ها و تمام مراحل فرعی بازی.', 3590.00, 'product_4.png'),
(5, 'Ubisoft 1years pc', 'به صورت اکانت روی pc شما خریداری میشود.\r\nدسترسی کامل به تمام بازی های شرکت بزرگ یوبیسافت به ادیشن کامل با تمام اسکین ها و تمام مراحل فرعی بازی.', 1190.00, 'product_5.png'),
(6, '	game pass 7 month home', 'اشتراک گیم پس 7 ماهه به صورت هوم هست که قابل استفاده به صورت هم افلاین هم انلاین روی اکانت خود هستید . اشتراک گیم پس با دسترسی به بیش از 1000 تا بازی هست که بازی هایی مثل call of duty از همان روز عرضه جهانی روی سرور قرار گرفته میشود.', 2040.00, 'product_6.png'),
(7, 'NBA 2K25 home', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 900.00, 'product_7.png'),
(8, 'NBA 2K25 swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 850.00, 'product_8.png'),
(9, 'Devil May Cry 5 Special Edition swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 300.00, 'product_9.png'),
(10, 'Alan Wake Remastered swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 130.00, 'product_10.jpg'),
(11, 'Assassin\'s Creed Mirage swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 200.00, 'product_11.jpg'),
(12, 'Assassin\'s Creed Valhalla swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 450.00, 'product_12.png'),
(106, 'Red Dead Redemption 2 Ultimate Edition swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 250.00, 'product_106.jpg'),
(107, 'Alan Wake Remastered home', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 230.00, 'product_107.jpg'),
(108, 'GTA V PREMIUM EDITION swith', 'توجه در ظرفیت هوم بازی هم به صورت افلاین هم به صورت انلاین در دسترس هست .\r\nاما در ظرفیت سویج بازی فقط در حالت انلاین در دسترس شما خواهد بود .', 150.00, 'product_108.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(45, 'tehrani', 'tahathrany27@gmail.com', '1275298230tt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders_table`
--
ALTER TABLE `orders_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders_table`
--
ALTER TABLE `orders_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders_table` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
