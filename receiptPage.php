<?php
require 'sqlConn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
}

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Additional check to ensure the user is valid
    $userQuery = $conn->prepare("SELECT * FROM `tbl_user` WHERE `user_id` = :userId");
    $userQuery->bindParam(':userId', $userId);
    $userQuery->execute();
    $user = $userQuery->fetch();

    if (!$user) {
        header('location:index.php');
        exit();
    }

    $userName = $user['user_name'];
    $isSeller = $user['is_seller'];
} else {
    header('location:index.php');
    exit();
}

// Fetch order history for the user
// Fetch order history for the user within a time range
// Fetch order history for the user
$orderHistoryQuery = $conn->prepare("SELECT oh.*, p.product_name, p.product_image, p.price 
                                     FROM `tbl_order_history` oh
                                     INNER JOIN `tbl_products` p ON oh.product_id = p.product_id
                                     WHERE oh.user_id = :userId
                                     ORDER BY oh.order_date DESC");
$orderHistoryQuery->bindParam(':userId', $userId);
$orderHistoryQuery->execute();
$orderItems = $orderHistoryQuery->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Thriftly</title>
    <style>
        /* Add your styles here */
        .receiptWrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        .receiptHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .thriftlyInfo h1,
        .thriftlyInfo h2 {
            margin: 0;
        }

        .logo img {
            max-width: 100px;
        }

        hr {
            margin: 20px 0;
            border: 1px solid #ddd;
        }

        .items {
            margin-bottom: 20px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items th,
        .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .priceTotal h2,
        .priceTotal h1 {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="receiptWrapper">

        <div class="receiptHeader">
            <div class="thriftlyInfo">
                <h1>Thriftly</h1>
                <h2>University of St. la Salle</h2>
            </div>
            <div class="logo">
                <img src="./assets/logoName.png" alt="Thriftly Logo">
            </div>
        </div>

        <hr>

        <h1>Bill to</h1>
        <h2><?php echo $user['first_name'] . " " . $user['last_name']; ?></h2>

        <hr>

        <?php if (!empty($orderItems)) : ?>
            <div class="items">
                <table>
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $orderItem) : ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($orderItem['product_image']) ?>" alt="<?= htmlspecialchars($orderItem['product_name']) ?>" style="max-width: 50px;"></td>
                                <td><?= htmlspecialchars($orderItem['product_name']) ?></td>
                                <td><?= htmlspecialchars($orderItem['quantity']) ?></td>
                                <td>₱<?= htmlspecialchars($orderItem['price']) ?></td>
                                <td>₱<?= number_format($orderItem['quantity'] * $orderItem['price'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>Your order history is empty.</p>
        <?php endif; ?>

        <hr>

        <div class="priceTotal">
            <?php
            $subtotal = 0;
            foreach ($orderItems as $orderItem) {
                $itemAmount = $orderItem['quantity'] * $orderItem['price'];
                $subtotal += $itemAmount;
            }
            ?>
            <h2>Subtotal: ₱<?= number_format($subtotal, 2) ?></h2>
            <h2>Sales tax: ₱0.00</h2>
            <h1>Total: ₱<?= number_format($subtotal, 2) ?></h1>
        </div>
    </div>
</body>

</html>