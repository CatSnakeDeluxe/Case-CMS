<?php
    session_start();
    ob_start();
    require_once "database.php";

    // Retreive the journal entry

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_markdown = trim($_POST["pagemarkdown"]);
        $form_id = trim($_POST["id"]);

        // Check if there is any text from user
        if (!empty($form_title) && !empty($form_markdown)) {
            // Prepare sql query to insert new journal entry
            $sqlquery = "UPDATE cms_page_markdown SET title='$form_title', pagemarkdown='$form_markdown' WHERE id=$form_id";
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
        $old_markdown = $row['pagemarkdown'];
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
        <div class="serverMessage">
            <?php
            // Write out message from other pages if exists

            if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                echo '<span class="dynamicMessage">' . $_SESSION['message'] . '<span>';
                unset( $_SESSION['message']);
            }
            ?>
        </div>
        <div>
            <form class="markdownForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="number" name="id" id="id" value="<?= $id ?>" hidden>    
                <h3>Page Title</h3>
                <input type="text" name="pagetitle" id="pagetitle" value="<?= $old_title ?>">
                <h3>Page Content</h3>
                <textarea name="pagemarkdown" id="pagemarkdown" cols="30" rows="18" value="<?= $old_markdown ?>"></textarea>
                <input class="btnOutline" type="submit" value="Save Changes">
            </form>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>