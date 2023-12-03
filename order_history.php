<?php
require 'sqlConn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
}

$userId = $_SESSION['user'];

// Fetch user's order history
$orderHistoryQuery = $conn->prepare("SELECT * FROM `orders` WHERE user_id = :userId ORDER BY order_date DESC");
$orderHistoryQuery->bindParam(':userId', $userId);
$orderHistoryQuery->execute();
$orderHistory = $orderHistoryQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head content here -->
    <title>Order History - Thrift.ly Store</title>
    <!-- Include your CSS and JS files here -->
</head>

<body>
    <!-- Include your header here -->

    <h2>Your Order History</h2>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Order Date</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderHistory as $order) : ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td>₱<?= htmlspecialchars($order['total_amount']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <!-- Add more cells for additional details -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Include your footer here -->
</body>

</html>