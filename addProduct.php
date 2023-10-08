<?php
require 'sqlConn.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeProduct'])) {
    $productId = $_POST['productId'];


    $deleteProductQuery = $conn->prepare("DELETE FROM `tbl_products` WHERE `product_id` = :productId");
    $deleteProductQuery->bindParam(':productId', $productId);

    if ($deleteProductQuery->execute()) {

        header("Location: {$_SERVER['PHP_SELF']}?user_id=$userId");
        exit();
    } else {

        echo "Failed to remove product. Please try again.";
        exit();
    }
}


if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
}


if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];


    $userQuery = $conn->prepare("SELECT * FROM `tbl_user` WHERE `user_id` = :userId");
    $userQuery->bindParam(':userId', $userId);
    $userQuery->execute();
    $user = $userQuery->fetch();


    if (!$user) {
        header('location:index.php');
        exit();
    }


    $productsQuery = $conn->prepare("SELECT p.*, c.category_name FROM `tbl_products` p
                                INNER JOIN `tbl_categories` c ON p.category_id = c.category_id
                                WHERE p.`user_id` = :userId");
    $productsQuery->bindParam(':userId', $userId);
    $productsQuery->execute();
    $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
} else {

    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style3.css">
    <link rel="stylesheet" href="styles/mobileLayout3.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift.ly Store</title>
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
</head>

<body>
    <?php
    $id = $_SESSION['user'];
    $sql = $conn->prepare("SELECT * FROM `tbl_user` WHERE `user_id`='$id'");
    $sql->execute();
    $fetch = $sql->fetch();
    ?>
    <div class="navBar">
        <div class="navBar1">
            <a href="homePage.php?user_id=<?php echo $_SESSION['user']; ?>"><span>Home</span></a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>"><span>Shop</span></a>
        </div>
        <div class="navBar2">
            <div class="navBarLeft">
                <div id="hamburgerIcon" onclick="toggleNavMenu()">
                    <i class="fas fa-bars"></i>
                </div>
                <img src="./assets/logoName.png" alt="">
            </div>

            <div class="navTwoRight">
                <?php
                $userProfilePicture = $fetch['profile_picture'];
                echo '<span onclick="togglePopup()"><img src="' . $userProfilePicture . '" alt="Welcome, ' . ucfirst($fetch['first_name']) . '!" class="user-profile-img"></span>';
                ?>
                <span><i class="fa-solid fa-cart-shopping"></i></span>
                <span><i class="fa-solid fa-globe" onclick="selectLanguage()"></i></span>
            </div>
            <div class="popup" id="logoutPopup">
                <button onclick="logout()">Logout</button>
            </div>
            <script>
                function togglePopup() {
                    var popup = document.getElementById('logoutPopup');
                    popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
                }

                function logout() {
                    window.location.href = 'logout.php';
                }

                function selectLanguage() {}
            </script>
        </div>

        <div class="add-item-container">
            <form id="addItemForm" action="process_add_item.php" method="post" enctype="multipart/form-data">
                <table id="productListings">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr class="existing-product">
                                <td><img src="<?= isset($product['product_image']) ? $product['product_image'] : ''; ?>" class="productImage" alt="Product Image"></td>
                                <td><?= $product['product_name']; ?></td>
                                <td><?= isset($product['category_name']) ? $product['category_name'] : ''; ?></td>
                                <td><?= $product['price']; ?></td>
                                <td>
                                    <input type="hidden" name="productId" value="<?= $product['product_id']; ?>">
                                    <button type="submit" name="removeProduct[]" value="<?= $product['product_id']; ?>">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr id="addItemRow">
                            <td colspan="4">
                                <button type="button" onclick="addNewItem()">Add an item...</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <button type="submit" name="submitItem">Save listings</button>
                <input type="hidden" name="formSubmitted" value="1">
            </form>
        </div>

        <script>
            <?php
            $categoryQuery = $conn->query("SELECT * FROM `tbl_categories`");
            $categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
            ?>


            function populateCategoriesDropdown(selectElement) {
                <?php foreach ($categories as $category) : ?>
                    var option = document.createElement("option");
                    option.value = "<?php echo $category['category_name']; ?>";
                    option.text = "<?php echo $category['category_name']; ?>";
                    selectElement.add(option);
                <?php endforeach; ?>
            }

            function addNewItem() {

                var tableBody = document.getElementById("productListings").getElementsByTagName('tbody')[0];


                var addItemRow = document.getElementById("addItemRow");
                if (addItemRow) {
                    tableBody.removeChild(addItemRow);
                }


                var newRow = tableBody.insertRow(tableBody.rows.length);


                var imageCell = newRow.insertCell(0);
                var nameCell = newRow.insertCell(1);
                var categoryCell = newRow.insertCell(2);
                var priceCell = newRow.insertCell(3);
                var actionCell = newRow.insertCell(4);


                var categorySelect = document.createElement("select");
                categorySelect.name = "category[]";
                categorySelect.required = true;
                populateCategoriesDropdown(categorySelect);
                categoryCell.appendChild(categorySelect);

                imageCell.innerHTML = '<input type="file" name="productImage[]" accept="image/*" required>';
                nameCell.innerHTML = '<input type="text" name="productName[]" required>';
                priceCell.innerHTML = '<input type="number" name="price[]" required>';
                actionCell.innerHTML = '<button type="button" onclick="removeRow(this)"><i class="fas fa-times-circle"></i></button>';


                var buttonRow = tableBody.insertRow(tableBody.rows.length);
                buttonRow.id = "addItemRow";
                var buttonCell = buttonRow.insertCell(0);
                buttonCell.colSpan = 4;
                buttonCell.innerHTML = '<button type="button" onclick="addNewItem()">Add an item...</button>';
            }

            function removeRow(button) {
                var row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);

                if (document.getElementById("productListings").getElementsByTagName('tbody')[0].rows.length === 1) {
                    addNewItem();
                }
            }
        </script>
    </div>
</body>

</html>