<?php 
    session_start();
    require_once "database.php";
    require_once "parsedown.php";

    $id = $_GET['id'];

    // Query the database
    $sqlquery = "SELECT * FROM cms_page_markdown WHERE id=$id";
    $result = $pdo->query($sqlquery);
    $cms_page_markdown = $result->fetch();
?>
<?php include_once "./partials/cms_head.php" ?>
<?php include_once "./partials/cms_navigation.php" ?>
<div class="cmsContent">
    <?php echo "<h1>" . $cms_page_markdown['title'] . "<h1>" ?>
    <?php 
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($cms_page_markdown['markdown']);

        echo $html;
    ?>
</div>
<?php include_once "./partials/cms_footer.php" ?>