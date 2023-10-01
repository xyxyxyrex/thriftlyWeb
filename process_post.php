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

    $sql = $conn->prepare("INSERT INTO tbl_posts (user_id, post_content, post_image) VALUES (?, ?, ?)");
    $sql->execute([$userId, $postContent, $targetFile]);

    header('Location: homePage.php');
    exit();
}
