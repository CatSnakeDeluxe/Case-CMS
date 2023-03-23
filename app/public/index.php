<?php
    session_start();
    include_once "database.php";
    include_once "parsedown.php";

    // redirect user to index page if already logged in
    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php include_once "./partials/logo.php" ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <p class="createPageBtn"><a href="createMarkdown.php" >Create Page | Markdown<i class="fa-solid fa-plus"></i></a></p>
        <p class="createPageBtn"><a href="createTinyMCE.php">Create Page | Editor<i class="fa-solid fa-plus"></i></a></p>
        <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
    </div>
    <div class="dashboardContent">
        <?php 
        // query the database
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);

        $sqlqueryEditor = "SELECT * FROM cms_page_editor";
        $resultEditor = $pdo->query($sqlqueryEditor);

        // $Parsedown = new Parsedown();

        // render the data
        echo '<div class="dynamicPages">';
        while($row = $resultMarkdown->fetch()) {
            $id = $row['id'];
            $edit = '<i class="fa-solid fa-pen-to-square"></i>';
            $delete = '<i class="fa-solid fa-trash"></i>';
            $dynamicContent = 'class="dynamicContent"';

            echo
            "<div " . $dynamicContent . ">
                <a href='view.php?id=$id'>
                    <p>" . $row['title'] . "</p>
                </a>
                <div>
                    <a href='editMarkdown.php?id=$id'>" . $edit . "</a>
                    <a href='delete.php?id=$id'>" . $delete . "</a>
                </div>
            </div>";
        }
        while($row = $resultEditor->fetch()) {
            $id = $row['id'];
            $edit = '<i class="fa-solid fa-pen-to-square"></i>';
            $delete = '<i class="fa-solid fa-trash"></i>';
            $dynamicContent = 'class="dynamicContent"';

            echo
            "<div " . $dynamicContent . ">
                <a href='view.php?id=$id'>
                    <p>" . $row['title'] . "</p>
                </a>
                <div>
                    <a href='editEditor.php?id=$id'>" . $edit . "</a>
                    <a href='delete.php?id=$id'>" . $delete . "</a>
                </div>
            </div>";
        }
        echo '</div>';
        ?>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>