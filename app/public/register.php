<?php
    session_start();
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

        if (move_uploaded_file($tmp_name, $target_directory . $name)) {
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
            $pdo->query("INSERT INTO user (email, username, password, filename) VALUES ('$form_email', '$form_username', '$hashed_password', '$name')");
            
            $id = $_SESSION['user_id'];
            // $sqlquerySettings = "SELECT * FROM settings WHERE id=$id";
            // $resultSettings = $pdo->query($sqlquerySettings);
            // $row = $resultSettings->fetch();

            // $check_if_settings_exist = $pdo->query("SHOW TABLES LIKE 'settings'");
            // $settings = $check_if_settings_exist->rowCount() == 1;

            // if($check_if_settings_exist->rowCount() == 1) {
            //     $pdo->query("INSERT INTO settings (font, background_color, header_footer_color, user_id) VALUES ('Poppins', '#fff', '#333', $id)");
            // }
            
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