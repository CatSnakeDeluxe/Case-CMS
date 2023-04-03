<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "database.php";

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_email = $_POST['email'];
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];
    $upload_success = false;

    if (!empty($_FILES)) {
    
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];
        $size = $_FILES['image']['size'];

        $allowed_file_extensions = ["jpg", "jpeg", "png"];
        $type_parts = explode("/", $type);
        $extension = $type_parts[1];

        if (!in_array($extension, $allowed_file_extensions)) {
            $_SESSION['message'] = "Not a valid file extension - Valid extensions [.jpg .jpeg .png]";
            header("location: register.php");
            exit();
        }

        if($size > 2000000) {
            $_SESSION['message'] = "File is too big to upload - max size is 2MB";
            header("location: register.php");
            exit();
        }

        $target_directory = $_SERVER['DOCUMENT_ROOT'] . "/cms-content/uploads/";

        $unique_name = time() . $name ;

        if (move_uploaded_file($tmp_name, $target_directory . $unique_name)) {
            $upload_success = true;
        }
    }

    if(!$form_username || !$form_password || !$form_email) {
        $_SESSION['message'] = "All fields required";
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
            $pdo->query("INSERT INTO user (email, username, password, filename) VALUES ('$form_email', '$form_username', '$hashed_password', '$unique_name')");
            
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
            echo '<span id="dynamicMessage">' . $_SESSION['message'] . '</span>';
            unset( $_SESSION['message']);
        }
        ?>
    </p>
    <p class="messageBubble"></p>
    <div class="whaleImgContainer">
        <img src="./cms-content/img/whale.png" alt="">
    </div>
</div>

<form class="loginRegisterForm" method="post" enctype="multipart/form-data">
    <h2>Register</h2>
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="text" name="username" id="username" placeholder="Username">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="file" name="image" id="image">

    <input class="btnOutline" type="submit" value="Register">
    <p class="formBottomLink">Already a user?<a href="login.php">Log In</a></p>
</form>
<?php include_once "./partials/footer.php" ?>