<?php
session_start();
include_once "database.php";

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$idToRemove = $_GET['id'];
$mode = $_GET['mode'];

if($mode == 'markdown' && isset($idToRemove)) {
    // Create sql query
    $sqlquery = "DELETE FROM cms_page_markdown where id=$idToRemove";
    $pdo->query($sqlquery);

    // Redirect
    $_SESSION['message'] = "Successfully deleted page";
    header("location: index.php");
} else {
    // Create sql query
    $sqlquery = "DELETE FROM cms_page_editor where id=$idToRemove";
    $pdo->query($sqlquery);

    // Redirect
    $_SESSION['message'] = "Successfully deleted page";
    header("location: index.php");
}
?>
<?php include_once "./partials/head.php" ?>
<h1>Delete</h1>
<?php include_once "./partials/footer.php" ?>