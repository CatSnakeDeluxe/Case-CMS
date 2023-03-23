<?php
    session_start();
    include_once "database.php";
    
    if (!isset($_SESSION["user_id"])) {
        header("location: login.php");
        exit();
    }

    // query the database
    // $sqlquery = "SELECT * FROM cms_page_markdown";
    // $result = $pdo->query($sqlquery);

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_markdown = trim($_POST["markdown"]);
        $user_id = $_SESSION['user_id'];

        // if(!$form_title) {
        //     $_SESSION['message'] = "Title needed";
        //     header("location: create.php");
        //     exit();
        // }

        // if(!$form_markdown) {
        //     $_SESSION['message'] = "Content needed";
        //     header("location: create.php");
        //     exit();
        // }

        $pdo->query("INSERT INTO cms_page_markdown (title, markdown, user_id) VALUES ('$form_title', '$form_markdown', $user_id)");
        $_SESSION['message'] = "Successfully added page";

        header("location: index.php");
    }  
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php include_once "./partials/logo.php" ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <a href="index.php" class="createPageBtn"><i class="fa-solid fa-arrow-left"></i>Take me back</a>
        <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
    </div>
    <div class="dashboardContent">
        <div class="dashboardHeader">
            <h2>Create a new page</h2>
            <!-- <button class="btnOutline btnDashboardHeader" onclick="showEditor()">Editor</button>
            <button class="btnOutline btnDashboardHeader" onclick="showMarkdown()">Markdown</button> -->
        </div>
        <div id="markdownOption">
            <form class="markdownForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="pagetitle" id="pagetitle" placeholder="Page Title">
                <textarea name="markdown" id="markdown" rows="14" placeholder="Write your markdown code here"></textarea>
                <input class="btnOutline" type="submit" value="Create Page">
            </form>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>