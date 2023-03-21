<?php
    session_start();
    include_once "database.php";

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
            <button onclick="openCreatePageForm()" class="createPageBtn" id="createPageBtn">Create page<i class="fa-solid fa-plus"></i></button>
            <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
        </div>
        <div class="dashboardContent">
            <div class="whaleContainer whaleContainerDashboard">
                <p class="whaleMessage" id="whaleMessage">
                    We made it to the dashboard. Good Job! I'm such a proud whale right now.
                </p>
                <p class="messageBubble"></p>
                <div class="whaleImgContainer">
                    <img src="./cms-content/img/whale.png" alt="">
                </div>
            </div>
            <div id="formDashboardContainer">
                <form method="post" id="createPageForm">
                    <p>
                        <input type="text" name="pagetitle" id="pagetitle" placeholder="Page Title">
                        <i onclick="closeCreatePageForm()" class="fa-regular fa-circle-xmark"></i>
                    </p>
                    <input id="createPageFormSubmit" type="submit" value="Create Page">
                </form>
            </div>
        </div>
    </div>
    <script src="./cms-content/js/functions.js"></script>
</body>
</html>