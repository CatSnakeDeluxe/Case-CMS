<nav>
    <div>
        <a href="index.php" class="backToDashboard">Back to Dashboard</a>
    </div>
    <div>
        <?php 
        $sqlqueryMarkdown = "SELECT * FROM cms_page_markdown";
        $resultMarkdown = $pdo->query($sqlqueryMarkdown);

        $sqlqueryEditor = "SELECT * FROM cms_page_editor";
        $resultEditor = $pdo->query($sqlqueryEditor);

        while($row = $resultMarkdown->fetch()) {
            $id = $row['id'];
            echo "<a href='view.php?id=$id&mode=markdown'>". $row['title'] ."</a>";
        }

        while($row = $resultEditor->fetch()) {
            $id = $row['id'];
            echo "<a href='view.php?id=$id&mode=editor'>". $row['title'] ."</a>";
        }
        ?>
    </div>
</nav>
