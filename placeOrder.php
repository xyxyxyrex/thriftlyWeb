<?php
require 'sqlConn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    $userId = $_SESSION['user'];

    // Fetch cart items for the user
    $cartQuery = $conn->prepare("SELECT c.*, p.product_name, p.price 
                                FROM `tbl_cart` c
                                INNER JOIN `tbl_products` p ON c.product_id = p.product_id
                                WHERE c.user_id = :userId");
    $cartQuery->bindParam(':userId', $userId);
    $cartQuery->execute();
    $cartItems = $cartQuery->fetchAll(PDO::FETCH_ASSOC);

    // Check if the cart is not empty
    if (empty($cartItems)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit();
    }

    // Start a database transaction
    $conn->beginTransaction();

    try {
        // Insert order details into tbl_order_history
        $orderDate = date('Y-m-d H:i:s'); // Current date and time
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];

            $orderInsertQuery = $conn->prepare("INSERT INTO `tbl_order_history` (`user_id`, `product_id`, `quantity`, `order_date`) 
                                               VALUES (:userId, :productId, :quantity, :orderDate)");
            $orderInsertQuery->bindParam(':userId', $userId);
            $orderInsertQuery->bindParam(':productId', $productId);
            $orderInsertQuery->bindParam(':quantity', $quantity);
            $orderInsertQuery->bindParam(':orderDate', $orderDate);
            $orderInsertQuery->execute();
        }

        // Clear the user's cart after successful order placement
        $clearCartQuery = $conn->prepare("DELETE FROM `tbl_cart` WHERE `user_id` = :userId");
        $clearCartQuery->bindParam(':userId', $userId);
        $clearCartQuery->execute();

        // Commit the transaction
        $conn->commit();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Error placing order']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
