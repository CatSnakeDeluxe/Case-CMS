<?php 
    session_start();
    include_once "database.php";
    include_once "parsedown.php";

    $id = $_GET['id'];
    $mode = $_GET['mode'];

    if($mode == 'markdown') {
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown WHERE id=$id";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);
        $cms_page_markdown = $resultMarkdown->fetch();
    } else {
        $sqlqueryEditor = "SELECT * FROM cms_page_editor WHERE id=$id";
        $resultEditor = $pdo->query($sqlqueryEditor);
        $cms_page_editor = $resultEditor->fetch();
    }
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
    <?php echo "<h1>" . $cms_page_editor['title'] . "<h1>" ?>
    <?php
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($cms_page_editor['content']);

        echo $html;
    ?>
</div>
<?php include_once "./partials/cms_footer.php" ?>