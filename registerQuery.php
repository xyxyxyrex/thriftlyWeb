<?php
session_start();
require_once 'sqlConn.php';

if (isset($_POST["register"])) {
    if ($_POST["firstname"] != "" && $_POST["lastname"] != "" && $_POST["username"] != "" && $_POST["password"] != "") {
        try {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            $timestamp = time();
            $targetDir = "uploads/pfp"; // specify the target directory for uploads
            $targetFile = $targetDir . '/' . $timestamp . '_' . basename($_FILES["profile_picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["profile_picture"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["profile_picture"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            // Now, you can use $targetFile in your database query to store the file path.

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO tbl_user (first_name, last_name, user_name, password, profile_picture) 
            VALUES ('$firstname', '$lastname', '$username', '$password', '$targetFile')";

            $conn->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $_SESSION['message'] = array("text" => "User successfully created!", "alert" => "");
        $conn = null;

        header('location:index.php');
    } else {
        echo "
            <script>alert('Please fill up the required field!')</script>
            <script>window.location = 'registerAccount.php'</script>
        ";
    }
}
