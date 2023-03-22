<?php
    session_start();
    include_once "database.php";

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_username = $_POST['username'];
    $form_password = $_POST['password'];

    if(!$form_username || !$form_password) {
        $_SESSION['message'] = "All fields required.";
        header('location: register.php');
        exit();
    }

    $result = $pdo->query("SELECT * FROM user WHERE username = '$form_username'");
    $user = $result->fetch();

        if ($user) {
            $_SESSION['message'] = "Username is already taken";
            header('location: register.php');
            exit();
        } else {
            $hashed_password = password_hash($form_password, PASSWORD_DEFAULT);
            $pdo->query("INSERT INTO user (username, password) VALUES ('$form_username', '$hashed_password')");
            $_SESSION['message'] = "Successfully created user! Please login.";
            header('location: login.php');
            exit();
        }
    }
?>
<?php include_once "./partials/head.php" ?>
<?php include_once "./partials/logo.php" ?>
<div class="whaleContainer">
    <p class="whaleMessage" id="whaleMessage">
        Let's get you registred. Isn't this exciting? We're gonna be the bestest friends.
        <?php
        // Write out message from other pages if exists
        if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
            echo '<span id="dynamicMessage">' . $_SESSION['message'] . '<span>';
            unset( $_SESSION['message']);
        }
        ?>
    </p>
    <p class="messageBubble"></p>
    <div class="whaleImgContainer">
        <img src="./cms-content/img/whale.png" alt="">
    </div>
</div>

<form method="post">
    <h2>Register</h2>
    <input type="text" name="username" id="username" placeholder="Username">
    <input type="password" name="password" id="password" placeholder="Password">

    <input class="btnOutline" type="submit" value="Register">
    <p class="formBottomLink">Already a user?<a href="login.php">Log In</a></p>
</form>
<?php include_once "./partials/footer.php" ?>