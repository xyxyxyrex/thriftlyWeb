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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style2.css">
    <link rel="stylesheet" href="styles/mobileLayout2.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift.ly Store</title>
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">

    <!-- Include your CSS styles here -->
    <style>
        /* Add your table styling here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-amount {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Your Cart</h2>

    <table>
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item) : ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="max-width: 50px;"></td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>₱<?= htmlspecialchars($item['price']) ?></td>
                    <!-- Add an input field for quantity with a unique identifier -->
                    <td>
                        <input type="number" class="quantity-input" value="<?= htmlspecialchars($item['quantity']) ?>" data-product-id="<?= htmlspecialchars($item['product_id']) ?>">
                    </td>
                    <td class="amount">₱<?= number_format($item['amount'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Calculate and display total amount -->
    <?php
    $totalAmountQuery = $conn->prepare("SELECT SUM(c.quantity * p.price) AS total FROM `tbl_cart` c
                                        INNER JOIN `tbl_products` p ON c.product_id = p.product_id
                                        WHERE c.user_id = :userId");
    $totalAmountQuery->bindParam(':userId', $userId);
    $totalAmountQuery->execute();
    $totalAmount = $totalAmountQuery->fetchColumn();
    ?>

    <div class="total-amount">
        <strong>Total Amount: ₱<?= number_format($totalAmount, 2) ?></strong>
    </div>

    <button id="placeOrderBtn" class="btn btn-primary">Place Order</button>

    <script>
        $(document).ready(function() {
            // Function to update amount and total amount based on quantity change
            function updateAmounts() {
                // Initialize totalAmount to zero
                var totalAmount = 0;

                // Loop through each row in the table
                $('tbody tr').each(function() {
                    var row = $(this);
                    var quantity = parseInt(row.find('.quantity-input').val()); // Use .val() for input fields
                    var price = parseFloat(row.find('td:nth-child(3)').text().substring(1)); // Extract numeric value without '₱'
                    var amount = quantity * price;

                    // Update the amount for this row
                    row.find('.amount').text('₱' + amount.toFixed(2));

                    // Add the amount to the total
                    totalAmount += amount;
                });

                // Update total amount
                $('.total-amount strong').text('Total Amount: ₱' + totalAmount.toFixed(2));
            }

            // Attach change event to quantity input for dynamic updates
            $('.quantity-input').on('input', function() {
                var quantity = parseInt($(this).val());
                if (!isNaN(quantity) && quantity >= 0) {
                    // Update the quantity text in the corresponding row
                    $(this).closest('tr').find('.quantity').text(quantity);

                    // Update amounts and total amount
                    updateAmounts();
                }
            });

            // Initial update on page load
            updateAmounts();

            // Place Order Button Click Event
            $('#placeOrderBtn').on('click', function() {
                // Assuming you have a script to handle order creation on the server-side
                $.ajax({
                    url: 'place_order.php', // Replace with the actual server-side script
                    method: 'POST',
                    success: function(orderId) {
                        // Redirect to the order history page with the newly created order ID
                        window.location.href = 'order_history.php?order_id=' + orderId;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error placing order:', error);
                        // You can add error handling here
                    }
                });
            });
        });
    </script>
</body>

</html>