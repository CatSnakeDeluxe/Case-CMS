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
            echo '<div class="dashboardImg"><img src="./cms-content/uploads/' . $resultUser->fetch()['filename'] . '"></div>';
        ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <p class="createPageBtn"><a href="createMarkdown.php" >Create Page | Markdown<i class="fa-solid fa-plus"></i></a></p>
        <p class="createPageBtn"><a href="createTinyMCE.php">Create Page | Editor<i class="fa-solid fa-plus"></i></a></p>
        <div class="iconContainer">
            <a href="logout.php" class="bottomIcon"><i class="fa-solid fa-door-open"></i></a>
            <a href="settings.php" class="bottomIcon"><i class="fa-solid fa-gear"></i></a>
        </div>
        </div>
        <div class="dashboardContent">
        <div class="whaleContainer whaleContainerLoggedIn">
            <p class="whaleMessage" id="whaleMessage">
                Here you can see all pages you have created. Isn't that neat?
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
        <?php 
        // query the database
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);

        $sqlqueryEditor = "SELECT * FROM cms_page_editor";
        $resultEditor = $pdo->query($sqlqueryEditor);

        // render the data
        echo '<div class="dynamicPages">';
        while($row = $resultMarkdown->fetch()) {
            $id = $row['id'];
            $edit = '<i class="fa-solid fa-pen-to-square"></i>';
            $delete = '<i class="fa-solid fa-trash"></i>';
            $dynamicContent = 'class="dynamicContent"';

            echo
            "<div " . $dynamicContent . ">
                <a href='view.php?id=$id&mode=markdown'>
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
                <a href='view.php?id=$id&mode=editor'>
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