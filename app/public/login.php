<?php 
    include_once "database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cms-content/css/style.css">
    <title>Whale Works</title>
</head>
<body>
    <?php include_once "./partials/logo.php" ?>
    <?php include_once "./partials/whale.php" ?>

    <form action="#">
        <h2>Login</h2>
        <input type="text" name="username" id="username" placeholder="Username">
        <input type="password" name="password" id="password" placeholder="Password">
        <a onclick="messageForgotPassword()" class="forgotPassword" href="#">Forgot Password?</a>

        <input type="submit" value="Log In">
        <p class="formBottomLink">Not a user?<a href="register.php">Register</a></p>
    </form>
    <script src="./cms-content/js/functions.js"></script>
</body>
</html>