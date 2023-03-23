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
        <a href="createMarkdown.php" class="createPageBtn">Create new page using markdown<i class="fa-solid fa-plus"></i></a>
        <a href="createTinyMCE.php" class="createPageBtn">Create new page using Editor<i class="fa-solid fa-plus"></i></a>
        <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
    </div>
    <div class="dashboardContent">
    <?php 
        // query the database
        $sqlquery = "SELECT * FROM cms_page_markdown";
        $result = $pdo->query($sqlquery);
        $Parsedown = new Parsedown();

        // render the data
        echo '<div class="dynamicPages">';
        while($row = $result->fetch()) {
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
                    <a href='edit.php?id=$id'>" . $edit . "</a>
                    <a href='delete.php?id=$id'>" . $delete . "</a>
                </div>
            </div>";

            // <a href='edit.php?id=$id'>" . $edit . "</a>
            //         <a href='delete.php?id=$id'>" . $delete . "</a>

            // echo
            //     "<div " . $dynamicContent . ">
            //         <div>
            //             <a href='view.php?id=$id'>" . $row['title'] . "</a>
            //         </div>
            //         <div>
            //             <a href='edit.php?id=$id'>" . $edit . "</a>
            //             <a href='delete.php?id=$id'>" . $delete . "</a>
            //         </div>
            //     </div>";
        }
        echo '</div>';
        ?>
        <!-- <div class="whaleContainer whaleContainerDashboard">
            <p class="whaleMessage" id="whaleMessage">
                You made it to the dashboard. Good Job! You can create or continue working with a page in the panel to the left.
            </p>
            <p class="messageBubble"></p>
            <div class="whaleImgContainer">
                <img src="./cms-content/img/whale.png" alt="">
            </div>
            <p id="closeWhaleContainer" onclick="closeWhaleContainer()">
                <i class="fa-solid fa-circle-xmark"></i>
            </p>
        </div> -->

    </div>
</div>
<?php include_once "./partials/footer.php" ?>