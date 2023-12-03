<?php
require 'sqlConn.php';
session_start();

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

    $userName = $user['user_name'];
    $isSeller = $user['is_seller'];
} else {
    header('location:index.php');
    exit();
}

$category = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($category)) {
    $productQuery = $conn->prepare("SELECT p.*, c.category_name FROM `tbl_products` p
                                    INNER JOIN `tbl_categories` c ON p.category_id = c.category_id
                                    WHERE c.category_name = :category");
    $productQuery->bindParam(':category', $category);
} else {
    $productQuery = $conn->prepare("SELECT p.*, c.category_name FROM `tbl_products` p
                                    INNER JOIN `tbl_categories` c ON p.category_id = c.category_id");
}

$productQuery->execute();
$products = $productQuery->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="styles/style2.css">
    <link rel="stylesheet" href="styles/mobileLayout2.css">
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
                <span onclick="redirectToCart()"><i class="fa-solid fa-cart-shopping"></i></span>
                <span><i class="fa-solid fa-globe" onclick="selectLanguage()"></i></span>
            </div>
            <div class="popup" id="logoutPopup">
                <button onclick="logout()">Logout</button>
            </div>

            <script>
                function redirectToCart() {
                    window.location.href = 'cartPage.php?user_id=<?= $_SESSION['user'] ?>';
                }
            </script>

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
        <script src="scripts/script1.js"></script>
    </div>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="assets/carouselImg/image1.png" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/carouselImg/image1.png" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/carouselImg/image1.png" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="navTwoCenter">
        <div class="searchBar">
            <input required type="text" name="searchItem" placeholder="Search for clothes...">
            <i class="fa-solid fa-search"></i>
        </div>
    </div>

    <div class="categories">
        <div class="categoriesNavbar">
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>">ALL</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=WOMEN">WOMEN</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=MEN">MEN</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=KIDS">KIDS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=JACKETS">JACKETS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=SHOES">SHOES</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=BEAUTY">BEAUTY</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=PETS">PETS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=TEENS">TEENS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=ACCESSORIES">ACCESSORIES</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=BABY">BABY</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=HATS">HATS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=JEANS">JEANS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=DRESSES">DRESSES</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=SPORTSWEAR">SPORTSWEAR</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=SWEATERS">SWEATERS</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=SWIMWEAR">SWIMWEAR</a>
            <a href="storePage.php?user_id=<?php echo $_SESSION['user']; ?>&category=UNDERWEAR">UNDERWEAR</a>

        </div>
    </div>
    <div class="filter-container">
        <span>Sort by: </span>
        <div class="filter-option" data-filter="relevance" onclick="setActiveFilter('relevance')">Relevance</div>
        <div class="filter-option" data-filter="top-selling" onclick="setActiveFilter('top-selling')">Top Selling</div>
        <div class="filter-option" data-filter="trending" onclick="setActiveFilter('trending')">Trending</div>
        <div class="price-dropdown" onclick="togglePriceDropdown()">
            Price<i class="fa-solid fa-caret-down"></i>
            <div class="price-dropdown-content">
                <a href="#">Low to High<i class="fa-solid fa-arrow-up"></i></a>
                <a href="#">High to Low<i class="fa-solid fa-arrow-down"></i></a>
            </div>
        </div>
        <?php

        if (isset($user['is_seller']) && $user['is_seller'] == 1) {
            echo '<div class="addItem">';
            echo '<a href="addProduct.php?user_id=' . $_SESSION['user'] . '"><span>List an item..</span></a>';
            echo '<i class="fa-solid fa-circle-plus"></i>';
            echo '</div>';
        }
        ?>
    </div>


    <script>
        function setActiveFilter(filterType) {

            var filterOptions = document.querySelectorAll('.filter-option');
            filterOptions.forEach(function(option) {
                option.classList.remove('active');
            });

            var clickedOption = document.querySelector('.filter-option[data-filter="' + filterType + '"]');
            if (clickedOption) {
                clickedOption.classList.add('active');
            }
        }

        function togglePriceDropdown() {

            var priceDropdown = document.querySelector('.price-dropdown');
            priceDropdown.classList.toggle('active');
        }


        window.onclick = function(event) {
            if (!event.target.matches('.price-dropdown')) {
                var dropdowns = document.getElementsByClassName("price-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('active')) {
                        openDropdown.classList.remove('active');
                    }
                }
            }
        }
    </script>

    <div class="product-container">
        <?php foreach ($products as $product) : ?>
            <div class="product-card">
                <img class="product-image" src="<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                <div class="infoWrapper">
                    <div class="productInfo">
                        <div class="product-name"><?= htmlspecialchars($product['product_name']) ?></div>
                        <div class="product-price">₱<?= htmlspecialchars($product['price']) ?></div>
                    </div>
                    <div class="user-info">
                        <?php
                        $userId = $product['user_id'];
                        $userQuery = $conn->prepare("SELECT * FROM `tbl_user` WHERE `user_id` = :userId");
                        $userQuery->bindParam(':userId', $userId);
                        $userQuery->execute();
                        $user = $userQuery->fetch();

                        if ($user) {
                            $userProfilePicture = $user['profile_picture'];
                            echo '<span><img src="' . htmlspecialchars($userProfilePicture) . '" alt="User" class="user-image"></span>';
                            echo '<div class="user-name">' . htmlspecialchars($user['user_name']) . '</div>';
                        }
                        ?>
                    </div>
                    <div class="addToCart" onclick="addToCart(<?= htmlspecialchars($product['product_id']) ?>)">
                        <span>Add To Cart</span>
                        <i class="fa-solid fa-circle-plus"></i>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function addToCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.open("GET", "addToCart.php?product_id=" + productId, true);
            xhr.send();
        }
    </script>




</body>

</html>