<?php
require 'sqlConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartItemId = $_POST['cart_item_id'];
    $newQuantity = $_POST['new_quantity'];

    // Update the quantity in the database
    $updateQuery = $conn->prepare("UPDATE `tbl_cart` SET `quantity` = :newQuantity WHERE `cart_id` = :cartItemId");
    $updateQuery->bindParam(':newQuantity', $newQuantity);
    $updateQuery->bindParam(':cartItemId', $cartItemId);
    $updateQuery->execute();

    // Respond with a success message or handle errors as needed
    echo json_encode(['status' => 'success']);
} else {
    // Respond with an error for non-POST requests
    echo json_encode(['status' => 'error']);
}
