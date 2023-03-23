<?php
    session_start();
    ob_start();
    include_once "database.php";

    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_content = trim($_POST["tinyEditor"]);
        $form_id = trim($_POST["id"]);

        // Check if there is any text from user
        if (!empty($form_title) && !empty($form_content)) {
            $sqlquery = "UPDATE cms_page_editor SET title='$form_title', content='$form_content' WHERE id=$form_id";
            $sqlStatement = $pdo->query($sqlquery);

            $_SESSION['message'] = "Successfully edited page";
            
            header("location: index.php");
        }
    } else {
        $id = $_GET['id'];
        $sqlquery = "SELECT * FROM cms_page_editor WHERE id=$id";
        $result = $pdo->query($sqlquery);
        $row = $result->fetch();

        $old_title = $row['title'];
        $old_content = $row['content'];
    }
    ob_end_flush();
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php include_once "./partials/logo.php" ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <a href="index.php" class="createPageBtn"><i class="fa-solid fa-arrow-left"></i>Take me back</a>
        <div class="iconContainer">
            <a href="logout.php" class="bottomIcon"><i class="fa-solid fa-door-open"></i></a>
            <a href="settings.php" class="bottomIcon"><i class="fa-solid fa-gear"></i></a>
        </div>
    </div>
    <div class="dashboardContent">
        <div class="dashboardHeader">
            <h2>Edit Page</h2>
        </div>
        <div class="editFormContainer">
            <form class="tinyEditorForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="number" name="id" id="id" value="<?= $id ?>" hidden>
                <input type="text" name="pagetitle" id="pagetitle" placeholder="Page Title" value="<?= $old_title ?>">
                <textarea id="tinyEditor" name="tinyEditor" placeholder="Start creating content here"><?php echo $old_content ?></textarea>
                <input class="btnOutline" type="submit" value="Save Page">
            </form>
            <script>
                tinymce.init({
                    selector: '#tinyEditor',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                    ],
                });
            </script>
        </div>
        <div class="whaleContainer whaleContainerLoggedIn">
            <p class="whaleMessage" id="whaleMessage">
                I'm here to tell you if anything goes wrong. You can do this!
                <?php
                // Write out message from other pages if exists
                if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                    echo '<span id="dynamicMessage">' . $_SESSION['message'] . '</span>';
                    unset( $_SESSION['message']);
                }
                ?>
            </p>
            <p class="messageBubble"></p>
            <div class="whaleImgContainer">
                <img src="./cms-content/img/whale.png" alt="">
            </div>
        </div>
    </div>
</div>
<?php include_once "./partials/footer.php" ?>