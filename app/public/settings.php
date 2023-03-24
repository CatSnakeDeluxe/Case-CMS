<?php
    session_start();
    include_once "database.php";
    include_once "parsedown.php";

    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php
            // Write out message from other pages if exists
            if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                echo '<div class="dynamicMessageContainerIndex"><span id="dynamicMessage">' . $_SESSION['message'] . '</span></div>';
                unset( $_SESSION['message']);
            }
        ?>
        <?php include_once "./partials/logo.php" ?>
        <?php
            $id = $_SESSION['user_id'];
            $sqlqueryUser = "SELECT * FROM user WHERE id=$id";
            $resultUser = $pdo->query($sqlqueryUser);
            echo '<div class="dashboardImg"><img src="./uploads/' . $resultUser->fetch()['filename'] . '"></div>';
        ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <a href="index.php" class="backBtn"><i class="fa-solid fa-arrow-left"></i>Take me back</a>
        <div class="iconContainer">
            <a href="logout.php" class="bottomIcon"><i class="fa-solid fa-door-open"></i></a>
            <a href="settings.php" class="bottomIcon"><i class="fa-solid fa-gear"></i></a>
        </div>
        </div>
        <div class="dashboardContent">
        <div class="dashboardHeader">
            <h2>General settings</h2>
        </div>
        <div class="whaleContainer whaleContainerLoggedIn">
            <p class="whaleMessage" id="whaleMessage">
                Here you can change colors and other fun stuff for your pages.
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

    </div>
</div>
<?php include_once "./partials/footer.php" ?>