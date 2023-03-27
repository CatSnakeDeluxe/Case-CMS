<?php
    session_start();
    include_once "database.php";
    
    if (!isset($_SESSION["user_id"])) {
        header("location: login.php");
        exit();
    }

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_markdown = trim($_POST["markdown"]);
        $user_id = $_SESSION['user_id'];

        if(!$form_title) {
            $_SESSION['message'] = "Title needed";
            header("location: createMarkdown.php");
            exit();
        }

        if(!$form_markdown) {
            $_SESSION['message'] = "Content needed";
            header("location: createMarkdown.php");
            exit();
        }

        $pdo->query("INSERT INTO cms_page_markdown (title, markdown, user_id) VALUES ('$form_title', '$form_markdown', $user_id)");
        $_SESSION['message'] = "Successfully added page";

        header("location: index.php");
    }  
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
            <h2>Create a new page</h2>
        </div>
        <div id="markdownOption">
            <form class="markdownForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="pagetitle" id="pagetitle" placeholder="Page Title">
                <textarea name="markdown" id="markdown" rows="14" placeholder="Write your markdown code here"></textarea>
                <input class="btnOutline" type="submit" value="Create Page">
            </form>
        </div>
        <div class="whaleContainer whaleContainerLoggedIn">
            <p class="whaleMessage" id="whaleMessage">
                I'm here to tell you if anything goes wrong. You can do this!
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