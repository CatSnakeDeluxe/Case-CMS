<?php
    session_start();
    include_once "database.php";
    include_once "parsedown.php";

    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //handle form submission
        $form_font = trim($_POST["font"]);
        $form_background_color = trim($_POST["colorBackground"]);
        $form_header_footer_background_color = trim($_POST["colorHeaderAndFooterBackground"]);
        $form_header_footer_text_color = trim($_POST["colorHeaderAndFooterText"]);
        $form_text_color = trim($_POST["colorText"]);
        
        $sqlquery = "UPDATE settings SET font='$form_font', background_color='$form_background_color', header_footer_background_color='$form_header_footer_background_color', header_footer_text_color='$form_header_footer_text_color', text_color='$form_text_color'";
        $sqlStatement = $pdo->query($sqlquery);

        $_SESSION['message'] = "Successfully saved settings";
        
        header("location: index.php");
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
        <div class="settingsContainer">
            <?php 
                $sqlquery_settings = "SELECT * FROM settings";
                $result_settings = $pdo->query($sqlquery_settings);
                $settings_for_user = $result_settings->fetch();
            ?>
            <form method="post" action="" id="settings">
                <h3>Colors</h3>
                <div class="option">
                    <p>Header and Footer Background</p>
                    <input type="color" name="colorHeaderAndFooterBackground" id="colorHeaderAndFooterBackground" value="<?= $settings_for_user['header_footer_background_color'] ?>">
                </div>
                <div class="option">
                    <p>Header and Footer Text</p>
                    <input type="color" name="colorHeaderAndFooterText" id="colorHeaderAndFooterText" value="<?= $settings_for_user['header_footer_text_color'] ?>">
                </div>
                <div class="option">
                    <p>Page Background</p>
                    <input type="color" name="colorBackground" id="colorBackground" value="<?= $settings_for_user['background_color'] ?>">
                </div>
                <div class="option">
                    <p>Page Text</p>
                    <input type="color" name="colorText" id="colorText" value="<?= $settings_for_user['text_color'] ?>">
                </div>
                <h3>Font</h3>
                <select class="option" name="font" id="font">
                    <option value="" selected disabled hidden>Current font: <?php echo $settings_for_user['font'] ?></option>
                    <option id="poppinsOption" value="Poppins">Poppins | The quick brown fox jumps over the lazy dog</option>
                    <option id="robotoOption" value="Roboto">Roboto | The quick brown fox jumps over the lazy dog</option>
                    <option id="merriweatherOption" value="Merriweather">Merriweather | The quick brown fox jumps over the lazy dog</option>
                </select>
                <input class="btnOutline" type="submit" value="Save Settings">
            </form>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>