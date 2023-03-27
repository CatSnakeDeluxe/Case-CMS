<?php
    session_start();
    include_once "database.php";
    
    if (!isset($_SESSION["user_id"])) {
        header("location: login.php");
        exit();
    }

    // handle form submission
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $form_title = trim($_POST["pagetitle"]);
    //     $form_markdown = trim($_POST["markdown"]);
    //     $user_id = $_SESSION['user_id'];

    //     if(!$form_title) {
    //         $_SESSION['message'] = "Title needed";
    //         header("location: createMarkdown.php");
    //         exit();
    //     }

    //     if(!$form_markdown) {
    //         $_SESSION['message'] = "Content needed";
    //         header("location: createMarkdown.php");
    //         exit();
    //     }

    //     $pdo->query("INSERT INTO cms_page_markdown (title, markdown, user_id) VALUES ('$form_title', '$form_markdown', $user_id)");
    //     $_SESSION['message'] = "Successfully added page";

    //     header("location: index.php");
    // }  
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php include_once "./partials/logo.php" ?>
        <?php
            $id = $_SESSION['user_id'];
            $sqlqueryUser = "SELECT * FROM user WHERE id=$id";
            $resultUser = $pdo->query($sqlqueryUser);
            echo '<div class="dashboardImg"><img src="./cms-content/uploads/' . $resultUser->fetch()['filename'] . '"></div>';
        ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <a href="index.php" class="backBtn"><i class="fa-solid fa-arrow-left"></i>Take me back</a>
        <div class="iconContainer">
            <a href="logout.php" class="bottomIcon"><i class="fa-solid fa-door-open"></i></a>
            <a href="settings.php" class="bottomIcon"><i class="fa-solid fa-gear"></i></a>
            <a href="user.php" class="bottomIcon"><i class="fa-solid fa-user"></i></a>
        </div>
    </div>
    <div class="dashboardContent">
        <div class="dashboardHeader">
            <h2>Users</h2>
        </div>
        <div>
            <?php
                $sqlqueryUsers = "SELECT * FROM user";
                $resultUsers = $pdo->query($sqlqueryUsers);

                // render the data
                echo '<div class="dynamicUsers">';
                while($row = $resultUsers->fetch()) {
                    // $id = $row['id'];
                    $dynamicUser = 'class="dynamicUser"';
                    $src = "./cms-content/uploads/";

                    echo
                    "<div " . $dynamicUser . ">
                        <div>
                            <p> " . $row['username'] . " </p>
                        </div>
                        <div>
                            <img src=" . $src . $row['filename'] . ">
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>