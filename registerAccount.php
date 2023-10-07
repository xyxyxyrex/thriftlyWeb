<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/splash.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="parentWrapper">
        <div class="leftWrapper">
            <div class="textArea">
                <h1>Relax.Brew.Enjoy</h1>
                <h3>A sanctuary of taste and tranquility. Experience a delightful fusion of flavors and ambience at Mellow Brews, where exceptional beverages and delectable cuisine harmoniously converge.</h3>
            </div>
            <img src="./assets/splashBg/splashBg2.jpg" class="background-image">
        </div>

        <div class="rightWrapper">
            <div class="loginForm">
                <form action="registerQuery.php" method="POST" enctype="multipart/form-data">
                    <div class="logoImage">
                        <img src="./assets/logoSqr.png">
                    </div>
                    <h1>Register an Account:</h1>

                    <label for="firstname">First Name</label>
                    <input id="firstname" type="text" name="firstname" placeholder="First Name">

                    <label for="lastname">Last Name</label>
                    <input id="lastname" type="text" name="lastname" placeholder="Last Name">

                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" placeholder="Enter your username">

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter your password">

                    <label for="profile-picture">Profile Picture</label>
                    <input id="profile-picture" type="file" name="profile_picture">
                    </br>

                    <label for="is-seller">Are you a seller?</label>
                    <input type="radio" id="is-seller-yes" name="is_seller" value="1"> Yes
                    <input type="radio" id="is-seller-no" name="is_seller" value="0" checked> No

                    <input type="submit" name="register">

                </form>
            </div>
        </div>
    </div>
</body>

</html>