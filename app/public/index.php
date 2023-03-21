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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cms-content/css/style.css">
    <script src="https://kit.fontawesome.com/bf456a88d2.js" crossorigin="anonymous"></script>
    <title>Whale Works</title>
</head>
<body>
    <div class="dashboardContainer">
        <div class="adminPanel">
            <?php include_once "./partials/logo.php" ?>
            <h2><?= $_SESSION['username'] ?></h2>
            <a href="create.php" class="createPageBtn">Create new page<i class="fa-solid fa-plus"></i></a>
            <!-- <button onclick="openCreatePageForm()" class="createPageBtn" id="createPageBtn">Create new page<i class="fa-solid fa-plus"></i></button> -->
            <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
        </div>
        <div class="dashboardContent">
            <div class="whaleContainer whaleContainerDashboard">
                <p class="whaleMessage" id="whaleMessage">
                    You made it to the dashboard. Good Job! I'm such a proud whale right now.
                </p>
                <p class="messageBubble"></p>
                <div class="whaleImgContainer">
                    <img src="./cms-content/img/whale.png" alt="">
                </div>
            </div>
            <?php 
        // Query the database
        $sqlquery = "SELECT * FROM cms_page";
        $result = $pdo->query($sqlquery);
        $Parsedown = new Parsedown();


        // Render the data
        echo "<section>";
        while($row = $result->fetch()) {
            $id = $row['id'];
            echo "<aside>
                    <p>" . $row['text'] . "</p>
                    <div>
                        <a href='delete.php?id=$id'>Delete</a>
                        <a href='edit.php?id=$id'>Edit</a>
                        <a href='view.php?id=$id'>View</a>
                    </div>
                </aside>
                <hr>";
        }
        echo "</section>";

    ?>
        </div>
    </div>
    <script src="./cms-content/js/functions.js"></script>
</body>
</html>