<?php
    session_start();
    include_once "database.php";
    
    if (!isset($_SESSION["user_id"])) {
        header("location: login.php");
        exit();
    }

    // Query the database
    $sqlquery = "SELECT * FROM cms_page";
    $result = $pdo->query($sqlquery);

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_text = trim($_POST["text"]);
        $user_id = $_SESSION['user_id'];

        // Check if there is any text from user
        if (!empty($form_text)) {
            // Prepare sql query to insert new journal entry
            $pdo->query("INSERT INTO cms_page (text, user_id) VALUES ('$form_text', $user_id)");
            $_SESSION['message'] = "Successfully added page";

            header("location: index.php");
        }
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
            <button onclick="showEditor()">Editor</button>
            <button onclick="showMarkdown()">Markdown</button>
        </div>
        <div id="markdownOption">
            <h2 class="optionTitle">MARKDOWN</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <textarea name="text" id="text" cols="30" rows="10"></textarea>
                <input type="submit" value="Create Page">
            </form>
        </div>
        <div id="editorOption">
            <h2 class="optionTitle">EDITOR</h2>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>