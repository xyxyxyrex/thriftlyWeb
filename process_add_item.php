<?php
require 'sqlConn.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmitted'])) {

    $user_id = $_SESSION['user'];
    $productNames = $_POST['productName'];
    $categories = $_POST['category'];
    $prices = $_POST['price'];


    if (isset($_POST['removeProduct']) && is_array($_POST['removeProduct'])) {
        foreach ($_POST['removeProduct'] as $productId) {

            $deleteProductQuery = $conn->prepare("DELETE FROM `tbl_products` WHERE `product_id` = :productId");
            $deleteProductQuery->bindParam(':productId', $productId);

            if (!$deleteProductQuery->execute()) {

                echo "Failed to remove product. Please try again.";
                exit();
            }
        }
    }


    foreach ($productNames as $key => $productName) {
        $productImage = '';
        if ($_FILES['productImage']['error'][$key] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES['productImage']['name'][$key]);
            move_uploaded_file($_FILES['productImage']['tmp_name'][$key], $target_file);
            $productImage = $target_file;
        }

        $checkCategoryQuery = $conn->prepare("SELECT `category_id` FROM `tbl_categories` WHERE `category_name` = :category");
        $checkCategoryQuery->bindParam(':category', $categories[$key]);
        $checkCategoryQuery->execute();

        $categoryRow = $checkCategoryQuery->fetch(PDO::FETCH_ASSOC);

        if (!$categoryRow) {

            echo "Error: Category '{$categories[$key]}' does not exist.";
            exit();
        }

        $insertProductQuery = $conn->prepare("INSERT INTO `tbl_products` (`user_id`, `product_name`, `category_id`, `price`, `product_image`) VALUES (:user_id, :productName, :category, :price, :productImage)");

        $insertProductQuery->bindParam(':user_id', $user_id);
        $insertProductQuery->bindParam(':productName', $productName);
        $insertProductQuery->bindParam(':category', $categoryRow['category_id']); // Use the category_id from tbl_categories
        $insertProductQuery->bindParam(':price', $prices[$key]);
        $insertProductQuery->bindParam(':productImage', $productImage);

        if ($insertProductQuery->execute()) {
        } else {
            echo "Failed to add product. Please try again.";
            exit();
        }
    }
    header("Location: addProduct.php?user_id=$user_id");
    exit();
} else {
    header('location:index.php');
    exit();
}
