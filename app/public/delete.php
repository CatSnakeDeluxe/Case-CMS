<?php
session_start();
include_once "database.php";

// Retreive which id to delete from url
$idToRemove = $_GET['id'];

if (isset($idToRemove)) {
    // Create sql query
    $sqlquery = "DELETE FROM cms_page_markdown where id=$idToRemove";
    $pdo->query($sqlquery);

    // Redirect
    $_SESSION['message'] = "Successfully deleted page";
    header("location: index.php");
}
?>
<?php include_once "./partials/head.php" ?>
<h1>Delete</h1>
<?php include_once "./partials/footer.php" ?>