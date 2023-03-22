<?php 
    session_start();
    require_once "database.php";
    require_once "parsedown.php";

    $id = $_GET['id'];

    // Query the database
    $sqlquery = "SELECT * FROM cms_page_markdown WHERE id=$id";
    $result = $pdo->query($sqlquery);
    $cms_page_markdown= $result->fetch();
?>
<?php include_once "./partials/head.php" ?>
<a href="index.php" class="backToDashboard"><i class="fa-solid fa-arrow-left"></i>Back to Dashboard</a>
<div>
    <?php 
        $parsedown = new Parsedown();
        $html = $parsedown->text($cms_page_markdown['pagemarkdown']);

        echo $html;
    ?>
</div>
<?php include_once "./partials/footer.php" ?>