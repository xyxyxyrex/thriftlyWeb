<?php
require 'sqlConn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
}

// Fetch cart items for the user
$userId = $_SESSION['user'];
$cartQuery = $conn->prepare("SELECT c.*, p.product_name, p.product_image, p.price, (c.quantity * p.price) AS amount FROM `tbl_cart` c
                            INNER JOIN `tbl_products` p ON c.product_id = p.product_id
                            WHERE c.user_id = :userId");
$cartQuery->bindParam(':userId', $userId);
$cartQuery->execute();
$cartItems = $cartQuery->fetchAll(PDO::FETCH_ASSOC);

error_log("Place order script is executed");

// ... Other necessary logic for calculating total amount and other details

// Handle placing the order in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Assuming you have an 'orders' table
        $orderInsert = $conn->prepare("INSERT INTO `orders` (user_id, total_amount, order_date) VALUES (:userId, :totalAmount, NOW())");
        $orderInsert->bindParam(':userId', $userId);
        $orderInsert->bindParam(':totalAmount', $totalAmount);
        $orderInsert->execute();

        // Get the last inserted order ID
        $orderId = $conn->lastInsertId();

        // Move cart items to order_items table
        foreach ($cartItems as $item) {
            $orderItemInsert = $conn->prepare("INSERT INTO `order_items` (order_id, product_id, quantity, price) VALUES (:orderId, :productId, :quantity, :price)");
            $orderItemInsert->bindParam(':orderId', $orderId);
            $orderItemInsert->bindParam(':productId', $item['product_id']);
            $orderItemInsert->bindParam(':quantity', $item['quantity']);
            $orderItemInsert->bindParam(':price', $item['price']);
            $orderItemInsert->execute();
        }

        // Clear the cart after placing the order
        $clearCart = $conn->prepare("DELETE FROM `tbl_cart` WHERE user_id = :userId");
        $clearCart->bindParam(':userId', $userId);
        $clearCart->execute();

        // Redirect to order history with the new order ID
        header('location:order_history.php?order_id=' . $orderId);
        exit();
    } catch (PDOException $e) {
        // Print any errors for debugging
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content here -->
    <title>Place Order - Thrift.ly Store</title>
    <!-- Include your CSS and JS files here -->
</head>

<body>
    <!-- Include your header here -->

    <h2>Your Cart - Ready to Order</h2>

    <table>
        <!-- Display cart items here -->
    </table>

    <div class="total-amount">
        <strong>Total Amount: ₱<?= htmlspecialchars($totalAmount) ?></strong>
    </div>

    <form method="post">
        <button type="submit">Place Order</button>
    </form>

    <!-- Include your footer here -->
</body>

</html>