<?php
    session_start();
    include_once "database.php";

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $form_username = $_POST['username'];
        $form_password = $_POST['password'];

        $result = $pdo->query("SELECT * FROM user WHERE username = '$form_username'");
        $user = $result->fetch();

        if (!$user) {
            $_SESSION['message'] = "Username does not exists";
            header("location: login.php");
            exit();
        }

        // compare password
        $correct_password = password_verify($form_password, $user['password']);
        
        if (!$correct_password) {
            $_SESSION['message'] = "Invalid password";
            header("location: login.php");
            exit();
        }

        // set user_id for session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['message'] = "Successfully logged in";
        // echo "success";
        // redirect to dashboard
        header("location: index.php");
        exit();
    }
?>
<?php include_once "./partials/head.php" ?>
<?php include_once "./partials/logo.php" ?>
<div class="whaleContainer">
    <p class="whaleMessage" id="whaleMessage">
        Let's login and get started creating amazing pages.
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
    <h2>Login</h2>
    <input type="text" name="username" id="username" placeholder="Username">
    <input type="password" name="password" id="password" placeholder="Password">
    <a onclick="messageForgotPassword()" class="forgotPassword" href="#">Forgot Password?</a>

    <input class="btnOutline" type="submit" value="Log In">
    <p class="formBottomLink">Not a user?<a href="register.php">Register</a></p>
</form>
<?php include_once "./partials/footer.php" ?>