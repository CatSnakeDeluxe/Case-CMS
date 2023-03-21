<?php 
    session_start();
    require_once "database.php";
    require_once "parsedown.php";

    $id = $_GET['id'];

    // Query the database
    $sqlquery = "SELECT * FROM cms_page WHERE id=$id";
    $result = $pdo->query($sqlquery);
    $cms_page = $result->fetch();
?>
<div>
<?php 
    $Parsedown = new Parsedown();
    $html = $Parsedown->text($cms_page['text']);

    echo $html;
?>
</div>