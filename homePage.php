<?php
require 'sqlConn.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:index.php');
}
if (isset($_POST["postContent"])) {
    $postContent = $_POST["postContent"];
}
$usersQuery = $conn->query("SELECT * FROM tbl_user");
$users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

$usersCount = count($users);

if (isset($_POST["postContent"])) {
    $postContent = $_POST["postContent"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style1.css">
    <link rel="stylesheet" href="styles/mobileLayout.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift.ly</title>
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
            <span>Home</span>
            <span>Shop</span>
        </div>
        <div class="navBar2">
            <div class="navBarLeft">
                <div id="hamburgerIcon" onclick="toggleNavMenu()">
                    <i class="fas fa-bars"></i>
                </div>
                <img src="./assets/logoName.png" alt="">
            </div>
            <div class="navTwoCenter">
                <span>Messages</span>
                <span>Search</span>
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
    </div>

    <div class="storyArea" id="storyArea">
        <button id="leftButton" onclick="scrollStories('left')"><i class="fa-solid fa-chevron-left"></i></button>
        <button id="rightButton" onclick="scrollStories('right')"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="story" id="story1">
            <img class="storyContent" src="https://picsum.photos/200/300" alt="Story Image">
            <img class="profilePicture" src="./assets/story2.png" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img cla ss="storyContent" src="https://picsum.photos/200/312" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/409" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/313" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/408" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/314" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/407" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/315" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/406" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/316" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/405" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/317" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/404" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/318" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/403" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/319" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/401" alt="Profile Picture">
        </div>
        <div class="story" id="story2">
            <img class="storyContent" src="https://picsum.photos/200/320" alt="Story Image">
            <img class="profilePicture" src="https://placekitten.com/800/402" alt="Profile Picture">
        </div>

        <script src="scripts/script1.js"></script>

    </div>
    <form action="process_post.php" method="post" enctype="multipart/form-data">
        <div class="postToFeed">
            <div class="addPicture" onclick="openFileExplorer()">
                <i class="fas fa-circle-plus"></i>
                <input type="file" name="file" id="fileInput" class="fileInput" accept="image/*" onchange="displayFileName()">
            </div>
            <div class="writePost">
                <input required type="text" name="postContent" placeholder="What's on your mind?">
            </div>
            <input type="submit" name="submitPost" class="submitButton" value="POST">
            <script src="./scripts/postToFeed.js"></script>
        </div>
    </form>
    <div class="vertFeedWrapper">
        <div class="vertNav">
            <ul>
                <li>
                    <h2>Top</h2>
                </li>
                <li>
                    <h2>Following</h2>
                </li>
                <li>
                    <h2><i class="fa-solid fa-video"></i> LIVE</h2>
                </li>
            </ul>
        </div>

        <div class="feedArea">
            <?php
            $postsQuery = $conn->query("SELECT tbl_posts.*, tbl_user.first_name, tbl_user.last_name FROM tbl_posts JOIN tbl_user ON tbl_posts.user_id = tbl_user.user_id ORDER BY post_date DESC");
            $posts = $postsQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($posts as $post) {
                echo '<div class="post">';
                echo '<div class="userImage"><img src="' . getProfilePicture($post['user_id']) . '" alt=""></div>';
                echo '<div class="postContent">';
                echo '<h3 style="margin: 0">' . $post['first_name'] . ' ' . $post['last_name'] . '</h3>';
                echo '<h4 style="margin: 0">' . '@' . getUsername($post['user_id']) . '</h4>';
                echo '<p class="postText">' . $post['post_content'] . '</p>';
                $postDate = new DateTime($post['post_date']);
                echo '<p class="postDate">' . $postDate->format('F j \a\t g:iA') . '</p>';
                if (!empty($post['post_image'])) {
                    echo '<img class="postImage" src="' . $post['post_image'] . '" alt="">';
                }
                echo '<div class="postButtons">';
                echo '<i class="fa-regular fa-heart"></i>';
                echo '<i class="fa-regular fa-comment"></i>';
                echo '</div>';
                echo '<div class="commentSection">';

                $commentsQuery = $conn->query("SELECT tbl_comments.*, tbl_user.profile_picture FROM tbl_comments JOIN tbl_user ON tbl_comments.user_id = tbl_user.user_id WHERE post_id = " . $post['post_id']);
                $comments = $commentsQuery->fetchAll(PDO::FETCH_ASSOC);

                foreach ($comments as $comment) {
                    echo '<div class="comment">';
                    echo '<div class="userImage"><img src="' . $comment['profile_picture'] . '" alt="">  </div>';
                    echo '<h4 class="commentUserName"margin: 0">' . '@' . getUsername($comment['user_id']) . '</h4>';
                    echo '<p>' . $comment['comment_content'] . '</p>';
                    echo '</div>';
                }

                echo '<form action="process_post.php" method="post" class="commentForm">';
                echo '<div class="commentInputContainer">';
                echo '<input class="commentInput" name="commentContent" placeholder="Add a comment..." class="commentInput" type="text">';
                echo '<input type="hidden" name="postId" value="' . $post['post_id'] . '">';
                echo '<button class="commentButton" type="submit" name="submitComment"><i class="fa-regular fa-paper-plane"></i></button>';
                echo '</div>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            function getProfilePicture($userId)
            {
                global $conn;
                $profilePictureQuery = $conn->query("SELECT profile_picture FROM tbl_user WHERE user_id = $userId");
                $profilePicture = $profilePictureQuery->fetchColumn();
                return $profilePicture;
            }

            function getUsername($userId)
            {
                global $conn;
                $usernameQuery = $conn->query("SELECT user_name FROM tbl_user WHERE user_id = $userId");
                $username = $usernameQuery->fetchColumn();
                return $username;
            }
            ?>
        </div>

        <div class="chatArea">
            <div class="chatLogo">
                <img id="chatLogo" src="assets/logoName.png" alt="">
            </div>
            <h2>Online: <?php echo '0/' . $usersCount; ?></h2>

            <?php
            $usersQuery = $conn->query("SELECT * FROM tbl_user");
            $users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user) {
                echo '<div class="user">';
                echo '<img class="profile-picture" src="' . $user['profile_picture'] . '" alt="Profile Picture">';
                echo '<h4 class="username">' . $user['user_name'] . '</h4>';
                echo '</div>';
            }
            ?>
        </div>

    </div>

</body>

</html>