CREATE TABLE `tbl_cart` (
  `cart_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `product_id` int(8) UNSIGNED NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_order_history` (
  `order_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `product_id` int(8) UNSIGNED NOT NULL,
  `quantity` int(5) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_categories` (
  `category_id` int(8) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_comments` (
  `comment_id` int(8) UNSIGNED NOT NULL,
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `comment_content` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_posts` (
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `post_content` text NOT NULL,
  `post_image` varchar(255) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_products` (
  `product_id` int(8) UNSIGNED NOT NULL,
  `category_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_reactions` (
  `reaction_id` int(8) UNSIGNED NOT NULL,
  `post_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(8) UNSIGNED NOT NULL,
  `reaction_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_user` (
  `user_id` int(8) UNSIGNED NOT NULL,
  `first_name` varchar(180) NOT NULL DEFAULT '',
  `last_name` varchar(180) NOT NULL DEFAULT '',
  `user_name` varchar(180) NOT NULL DEFAULT '',
  `password` varchar(180) NOT NULL DEFAULT '',
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_seller` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `tbl_order_history`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_order_history`
  MODIFY `order_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_products`
  MODIFY `product_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `tbl_reactions`
  MODIFY `reaction_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_user`
  MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `tbl_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `tbl_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`);

ALTER TABLE `tbl_order_history`
  ADD CONSTRAINT `tbl_order_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`),
  ADD CONSTRAINT `tbl_order_history_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`product_id`);

ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_posts` (`post_id`),
  ADD CONSTRAINT `tbl_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

ALTER TABLE `tbl_posts`
  ADD CONSTRAINT `tbl_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

ALTER TABLE `tbl_products`
  ADD CONSTRAINT `tbl_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`),
  ADD CONSTRAINT `tbl_products_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);

ALTER TABLE `tbl_reactions`
  ADD CONSTRAINT `tbl_reactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `tbl_posts` (`post_id`),
  ADD CONSTRAINT `tbl_reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`);
COMMIT;
