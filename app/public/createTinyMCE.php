<?php
    session_start();
    include_once "database.php";
    
    if (!isset($_SESSION["user_id"])) {
        header("location: login.php");
        exit();
    }

    // query the database
    // $sqlquery = "SELECT * FROM cms_page_markdown";
    // $result = $pdo->query($sqlquery);

    // handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_title = trim($_POST["pagetitle"]);
        $form_tinyeditor = trim($_POST["tinyEditor"]);
        $user_id = $_SESSION['user_id'];

        // if(!$form_title) {
        //     $_SESSION['message'] = "Title needed";
        //     header("location: create.php");
        //     exit();
        // }

        // if(!$form_markdown) {
        //     $_SESSION['message'] = "Content needed";
        //     header("location: create.php");
        //     exit();
        // }

        $pdo->query("INSERT INTO cms_page_markdown (title, markdown, user_id) VALUES ('$form_title', '$form_tinyeditor', $user_id)");
        $_SESSION['message'] = "Successfully added page";

        header("location: index.php");
    }  
?>
<?php include_once "./partials/head.php" ?>
<div class="dashboardContainer">
    <div class="adminPanel">
        <?php include_once "./partials/logo.php" ?>
        <h2><?= $_SESSION['username'] ?></h2>
        <a href="index.php" class="createPageBtn"><i class="fa-solid fa-arrow-left"></i>Take me back</a>
        <a href="logout.php" class="logoutBtn"><i class="fa-solid fa-door-open"></i></a>
    </div>
    <div class="dashboardContent">
        <div class="dashboardHeader">
            <h2>Create a new page</h2>
            <!-- <button class="btnOutline btnDashboardHeader" onclick="showEditor()">Editor</button>
            <button class="btnOutline btnDashboardHeader" onclick="showMarkdown()">Markdown</button> -->
        </div>
        <div id="editorOption">
            <form class="tinyEditorForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="pagetitle" id="pagetitle" placeholder="Page Title">
                <textarea id="tinyEditor" name="tinyEditor" placeholder="Start creating content here"></textarea>
                <input class="btnOutline" type="submit" value="Create Page">
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
    </div>
</div>
<?php include_once "./partials/footer.php" ?>

