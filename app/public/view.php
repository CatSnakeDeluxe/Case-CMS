<?php 
    session_start();
    include_once "database.php";
    include_once "parsedown.php";

    $id = $_GET['id'];
    $mode = $_GET['mode'];

    $sqlquery_settings = "SELECT * FROM settings";
    $result_settings = $pdo->query($sqlquery_settings);
    $settings_for_user = $result_settings->fetch();

    if(!$settings_for_user) {
        $pdo->query("INSERT INTO settings (font, background_color, header_footer_background_color, header_footer_text_color, text_color) VALUES ('Poppins', '#ffffff', '#E3EDFF', '#2A3853', '#2A3853')");
    }

    if($mode == 'markdown') {
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown WHERE id=$id";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);
        $cms_page_markdown = $resultMarkdown->fetch();
    } else if($mode == 'editor') {
        $sqlqueryEditor = "SELECT * FROM cms_page_editor WHERE id=$id";
        $resultEditor = $pdo->query($sqlqueryEditor);
        $cms_page_editor = $resultEditor->fetch();
    }

    if(!$mode) {
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);
        $cms_page_markdown = $resultMarkdown->fetch();

        if(!$cms_page_markdown) {
            $sqlqueryEditor = "SELECT * FROM cms_page_editor";
            $resultEditor = $pdo->query($sqlqueryEditor);
            $cms_page_editor = $resultEditor->fetch();
        }
    }
?>
<?php include_once "./partials/cms_head.php" ?>

<style>
body {
    color: <?= $settings_for_user['text_color']; ?>;
    font-family: <?= $settings_for_user['font']; ?>;
    background: <?= $settings_for_user['background_color']; ?>;
}

nav {
    background: <?= $settings_for_user['header_footer_background_color']; ?>;
}

nav a {
    color: <?= $settings_for_user['header_footer_text_color']; ?>;
}

footer {
    color: <?= $settings_for_user['header_footer_text_color']; ?>;
    background: <?= $settings_for_user['header_footer_background_color']; ?>;
}

<?php  
    if (!isset($_SESSION['user_id'])) {
        echo ".backToDashboard {
            display: none;
        }";
    };
?>
</style> 
<div class="flexContainer">
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
</div>
<?php include_once "./partials/cms_footer.php" ?>