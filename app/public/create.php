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
        $form_markdown = trim($_POST["pagemarkdown"]);
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

        $pdo->query("INSERT INTO cms_page_markdown (title, pagemarkdown, user_id) VALUES ('$form_title', '$form_markdown', $user_id)");
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
        <div class="createPageHeader">
            <h2>Create a new page</h2>
            <button class="btnOutline" onclick="showEditor()">Editor</button>
            <button class="btnOutline" onclick="showMarkdown()">Markdown</button>
        </div>
        <div class="serverMessage">
            <?php
            // Write out message from other pages if exists

            if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                echo '<span class="dynamicMessage">' . $_SESSION['message'] . '<span>';
                unset( $_SESSION['message']);
            }
            ?>
        </div>
        <div id="markdownOption">
            <h2 class="optionTitle">MARKDOWN</h2>
            <form class="markdownForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h3>Page Title</h3>
                <input type="text" name="pagetitle" id="pagetitle">
                <h3>Page Content</h3>
                <textarea name="pagemarkdown" id="pagemarkdown" cols="30" rows="18"></textarea>
                <input class="btnOutline" type="submit" value="Create Page">
            </form>
        </div>
        <div id="editorOption">
            <h2 class="optionTitle">EDITOR</h2>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>