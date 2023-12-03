<?php
require 'sqlConn.php';
session_start();

// Error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user'])) {
    echo 'User not logged in';
    exit();
}

if (!isset($_GET['product_id'])) {
    echo 'Product ID not provided';
    exit();
}

$productId = $_GET['product_id'];
$userId = $_SESSION['user'];

// Check if the product and user exist
$productQuery = $conn->prepare("SELECT * FROM `tbl_products` WHERE `product_id` = :productId");
$productQuery->bindParam(':productId', $productId);
$productQuery->execute();
$product = $productQuery->fetch();

$userQuery = $conn->prepare("SELECT * FROM `tbl_user` WHERE `user_id` = :userId");
$userQuery->bindParam(':userId', $userId);
$userQuery->execute();
$user = $userQuery->fetch();

if (!$product || !$user) {
    echo 'Invalid product or user';
    exit();
}

// Insert the product into the cart table
$insertCartQuery = $conn->prepare("INSERT INTO `tbl_cart` (`user_id`, `product_id`, `quantity`) VALUES (:userId, :productId, 1)");
$insertCartQuery->bindParam(':userId', $userId);
$insertCartQuery->bindParam(':productId', $productId);

if (!$insertCartQuery->execute()) {
    echo 'Error adding product to cart: ' . $insertCartQuery->errorInfo()[2];
    exit();
}

echo 'Product added to cart successfully';
