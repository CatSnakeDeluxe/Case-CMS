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
        <a href="create.php" class="createPageBtn">Create new page<i class="fa-solid fa-plus"></i></a>
        <?php 
        // query the database
        $sqlquery = "SELECT * FROM cms_page_markdown";
        $result = $pdo->query($sqlquery);
        $Parsedown = new Parsedown();

        // render the data
        echo '<div class="dynamicPages">';
        while($row = $result->fetch()) {
            $id = $row['id'];
            echo 
                "<p>" . $row['title'] . "</p>
                <div>
                    <a href='view.php?id=$id'>View</a>
                    <a href='edit.php?id=$id'>Edit</a>
                    <a href='delete.php?id=$id'>Delete</a>
                </div>";
        }
        echo '</div>';
        ?>
        <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
    </div>
    <div class="dashboardContent">
        <div class="whaleContainer whaleContainerDashboard">
            <p class="whaleMessage" id="whaleMessage">
                You made it to the dashboard. Good Job! You can create or continue working with a page in the panel to the left.
            </p>
            <p class="messageBubble"></p>
            <div class="whaleImgContainer">
                <img src="./cms-content/img/whale.png" alt="">
            </div>
        </div>

    </div>
</div>
<?php include_once "./partials/footer.php" ?>