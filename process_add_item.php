<?php
require 'sqlConn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user'];

    // Check if form fields are set
    if (
        isset($_POST['category'], $_POST['productName'], $_POST['price']) &&
        isset($_FILES['productImage']['name'])
    ) {
        // Retrieve form data
        $categories = $_POST['category'];
        $productNames = $_POST['productName'];
        $prices = $_POST['price'];
        $images = $_FILES['productImage'];

        // Loop through each product and insert into tbl_products
        for ($i = 0; $i < count($categories); $i++) {
            $category = $categories[$i];
            $productName = $productNames[$i];
            $price = $prices[$i];
            $image = $images['name'][$i];

            // Handle file upload for product image
            $targetDir = "uploads/products";  // Set your upload directory
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($images['tmp_name'][$i], $targetFile);

            // Insert product data into tbl_products
            $insertProductQuery = $conn->prepare("INSERT INTO tbl_products (category_id, user_id, product_name, product_image, price) VALUES ((SELECT category_id FROM tbl_categories WHERE category_name = :category), :userId, :productName, :productImage, :price)");
            $insertProductQuery->bindParam(':category', $category);
            $insertProductQuery->bindParam(':userId', $userId);
            $insertProductQuery->bindParam(':productName', $productName);
            $insertProductQuery->bindParam(':productImage', $targetFile);
            $insertProductQuery->bindParam(':price', $price);
            $insertProductQuery->execute();
        }

        // Redirect after successful insertion
        header('location: storePage.php?user_id=' . $userId);
        exit();
    } else {
        // Handle case where form fields are not set
        echo "Form fields are not set.";
        exit();
    }
} elseif (isset($_GET['remove_product_id'])) {
    // Remove product if the product ID is provided
    $productId = $_GET['remove_product_id'];

    $deleteProductQuery = $conn->prepare("DELETE FROM `tbl_products` WHERE `product_id` = :productId");
    $deleteProductQuery->bindParam(':productId', $productId);

    if ($deleteProductQuery->execute()) {
        // Redirect after successful deletion
        header('location: storePage.php?user_id=' . $userId);
        exit();
    } else {
        // Handle deletion failure (you may choose to display an error message)
        echo "Failed to remove product. Please try again.";
        exit();
    }
} else {
    // Redirect if the form is not submitted via POST and no product removal request
    header('location: index.php');
    exit();
}
