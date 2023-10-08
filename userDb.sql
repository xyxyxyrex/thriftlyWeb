-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2023 at 04:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `product_id` int(8) UNSIGNED NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(8) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`) VALUES
(1, 'ALL'),
(2, 'WOMEN'),
(3, 'MEN'),
(4, 'KIDS'),
(5, 'JACKETS'),
(6, 'SHOES'),
(7, 'BEAUTY'),
(8, 'PETS'),
(9, 'TEENS'),
(10, 'ACCESSORIES'),
(11, 'BABY'),
(12, 'HATS'),
(13, 'JEANS'),
(14, 'DRESSES'),
(15, 'SPORTSWEAR'),
(16, 'SWEATERS'),
(17, 'SWIMWEAR'),
(18, 'UNDERWEAR');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(8) UNSIGNED NOT NULL,
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `comment_content` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `post_content` text NOT NULL,
  `post_image` varchar(255) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(8) UNSIGNED NOT NULL,
  `category_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `category_id`, `user_id`, `product_name`, `product_image`, `price`) VALUES
(18, 12, 7, 'British Style Wool Fedoras Hat For Women Men Winter Autumn Warm Vintage Belt', 'uploads/ British Style Wool Fedoras Hat For Women Men Winter Autumn Warm Vintage Belt.jpg', 450.00),
(19, 12, 7, 'Floral Printed Baseball Cap for Men and Women', 'uploads/ Floral Printed Baseball Cap for Men and Women .jpg', 350.00),
(20, 12, 7, 'Baseball Summer Sun Caps Casual Style', 'uploads/Baseball Summer Sun Caps Casual Style.jpg', 250.00),
(21, 12, 7, '  Elegant Women_s Organza Bucket Hat Purple with Flower Design', 'uploads/Elegant Women_s Organza Bucket Hat Purple with Flower Design.jpg', 499.00),
(22, 12, 7, '  Fashion Hiking Camping UV Protection Cotton Linen Panama Cap Bucket Hat', 'uploads/Fashion Hiking Camping UV Protection Cotton Linen Panama Cap Bucket Hat ....jpeg', 450.00),
(23, 12, 7, '  Iconoclast Bands merch Bucket hat', 'uploads/Iconoclast Bands merch Bucket hat.jpg', 350.00),
(24, 12, 7, '  Japanese Print Bucket Hat Folding Sun Hat Summer Cap', 'uploads/Japanese Print Bucket Hat Folding Sun Hat Summer Cap.jpg', 850.00),
(25, 12, 7, ' Military Tactical Boonie Bucket Hat Folding Wide Brim', 'uploads/Military Tactical Boonie Bucket Hat Folding Wide Brim.jpg', 499.00),
(26, 12, 7, ' Nike Dri-FIT Club Structured Blank Front Cap', 'uploads/Nike Dri-FIT Club Structured Blank Front Cap.jpg', 650.00),
(27, 12, 7, ' Solid Color Unisex Baseball Cap Snapback Caps Casquette Hats Fitted Casual Gorras ...', 'uploads/Solid Color Unisex Baseball Cap Snapback Caps Casquette Hats Fitted Casual Gorras ....jpg', 799.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reactions`
--

CREATE TABLE `tbl_reactions` (
  `reaction_id` int(8) UNSIGNED NOT NULL,
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `reaction_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(8) UNSIGNED NOT NULL,
  `first_name` varchar(180) NOT NULL DEFAULT '',
  `last_name` varchar(180) NOT NULL DEFAULT '',
  `user_name` varchar(180) NOT NULL DEFAULT '',
  `password` varchar(180) NOT NULL DEFAULT '',
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_seller` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `first_name`, `last_name`, `user_name`, `password`, `profile_picture`, `is_seller`) VALUES
(6, 'not', 'seller', 'notseller', '123', 'uploads/pfp/placeholder.png', 1),
(7, 'seller', 'seller', 'seller', '123', 'uploads/pfp/placeholder.png', 1),
(8, 'asd', 'asd', 'asd', 'asd', 'uploads/pfp/placeholder.png', 1),
(9, 'notseller', 'notseller', 'notseller1', '123', 'uploads/pfp/placeholder.png', 1),
(10, 'notseller2', 'notseller2', 'notseller2', '123', 'uploads/pfp/placeholder.png', 0),
(11, 'seller2', 'seller2', 'seller', '123', 'uploads/pfp/placeholder.png', 0),
(12, 'seller3', 'seller3', 'seller3', '123', 'uploads/pfp/placeholder.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_reactions`
--
ALTER TABLE `tbl_reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_reactions`
--
ALTER TABLE `tbl_reactions`
  MODIFY `reaction_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`);

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_posts` (`post_id`),
  ADD CONSTRAINT `tbl_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD CONSTRAINT `tbl_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `tbl_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`),
  ADD CONSTRAINT `tbl_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

--
-- Constraints for table `tbl_reactions`
--
ALTER TABLE `tbl_reactions`
  ADD CONSTRAINT `tbl_reactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_posts` (`post_id`),
  ADD CONSTRAINT `tbl_reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;