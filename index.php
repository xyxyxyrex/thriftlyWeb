<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/splash.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thriftly: Log In</title>
</head>

<body>
    <div class="parentWrapper">
        <div class="leftWrapper">
            <div class="gradBg"></div>
            <div class="textArea">
                <h1>Thriftly.</h1>
                <h3>Embark on a journey of style and substance at Thriftly, the epitome of modern coolness. Dive into a curated selection that transcends fashion norms, where vintage vibes collide with contemporary edge. Thriftly is your portal to curated chicness, where every click unveils a style revolution. Break free from the ordinary, redefine your wardrobe, and embrace sustainable swagger. Elevate your fashion game at Thriftly.</h3>
            </div>
            <img src="assets/splashBg/splashBg1.jpg" class="background-image">
        </div>


        <div class="rightWrapper">
            <div class="loginForm">
                <form action="loginQuery.php" method="POST">
                    <h2> <?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message']['alert'];
                                echo $_SESSION['message']['text'];
                            }

                            unset($_SESSION['message']);
                            ?></h2>
                    <div class="logoImage">
                        <img src="assets/logoSqr.png">
                    </div>
                    <h1>Log in to your account:</h1>
                    </br>
                    <label for="username">Username</label>
                    </br>
                    <input id="username" type="text" name="username" placeholder="Enter your username">
                    </br>
                    <label for="password">Password</label>
                    </br>
                    <input id="password" type="password" name="password" placeholder="Enter your password">
                    </br>
                    <a style='float:right;' href="forgotPassword.php">Forgot Password?</a>
                    </br>
                    </br>
                    <input name="login" type="submit" value="L O G  I N" />
                    <br><br><br><br>

                    <div class="registerAccountButton">
                        <p>Don't have an account? <a href="registerAccount.php">Register an account</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>