<?php
    session_start();
    ob_start();
    require_once "database.php";

    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_markdown = trim($_POST["markdown"]);
        $form_id = trim($_POST["id"]);

        // Check if there is any text from user
        if (!empty($form_title) && !empty($form_markdown)) {
            // Prepare sql query to insert new journal entry
            $sqlquery = "UPDATE cms_page_markdown SET title='$form_title', markdown='$form_markdown' WHERE id=$form_id";
            $sqlStatement = $pdo->query($sqlquery);

            $_SESSION['message'] = "Successfully edited page";
            
            header("location: index.php");
        }
    } else {
        $id = $_GET['id'];

        // Query the database
        $sqlquery = "SELECT * FROM cms_page_markdown WHERE id=$id";
        $result = $pdo->query($sqlquery);
        $row = $result->fetch();

        $old_title = $row['title'];
        $old_markdown = $row['markdown'];
    }
    ob_end_flush();
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
            <h2>Edit Page</h2>
        </div>
        <div class="editFormContainer">
            <form class="markdownForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="number" name="id" id="id" value="<?= $id ?>" hidden>
                <input type="text" name="pagetitle" id="pagetitle" value="<?= $old_title ?>">
                <textarea name="markdown" id="markdown" rows="18"><?php echo $old_markdown ?></textarea>
                <input class="btnOutline" type="submit" value="Save Changes">
            </form>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>