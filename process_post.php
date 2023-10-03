<?php
session_start();
require_once 'sqlConn.php';

if (isset($_POST["submitPost"])) {
    $userId = $_SESSION['user'];
    $postContent = $_POST["postContent"];

    $timestamp = time();
    $randomChars = bin2hex(random_bytes(5));
    $targetDir = "uploads/post/";
    $targetFile = $targetDir . $timestamp . '_' . $randomChars . '_' . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);

    $sqlPost = $conn->prepare("INSERT INTO tbl_posts (user_id, post_content, post_image) VALUES (?, ?, ?)");
    $sqlPost->execute([$userId, $postContent, $targetFile]);

    $postId = $conn->lastInsertId();

    $reactionType = 'heart';
    $sqlReaction = $conn->prepare("INSERT INTO tbl_reactions (post_id, user_id, reaction_type) VALUES (?, ?, ?)");
    $sqlReaction->execute([$postId, $userId, $reactionType]);

    if (isset($_POST["commentContent"])) {
        $commentContent = $_POST["commentContent"];
        $sqlComment = $conn->prepare("INSERT INTO tbl_comments (post_id, user_id, comment_content) VALUES (?, ?, ?)");
        $sqlComment->execute([$postId, $userId, $commentContent]);
    }

    header('Location: homePage.php');
    exit();
} elseif (isset($_POST["submitComment"])) {

    $userId = $_SESSION['user'];
    $postId = $_POST["postId"];
    $commentContent = $_POST["commentContent"];

    $sqlComment = $conn->prepare("INSERT INTO tbl_comments (post_id, user_id, comment_content) VALUES (?, ?, ?)");
    $sqlComment->execute([$postId, $userId, $commentContent]);

    header('Location: homePage.php');
    exit();
}
