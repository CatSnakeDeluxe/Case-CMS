<?php
    // LINODE
    // define('DB_SERVER', 'localhost');
    // define('DB_USERNAME', 'cms_user_linode');
    // define('DB_PASSWORD', 'ZY3eDmRchz');
    // define('DB_NAME', 'cms');

    // LOCAL
    define('DB_SERVER', 'mysql');
    define('DB_USERNAME', 'db_user');
    define('DB_PASSWORD', 'db_password');
    define('DB_NAME', 'db_lamp_app');

    try {
        // connect to db
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

        // if something goes wrong throw exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // check if the tables exist
        $result = $pdo->query("SHOW TABLES LIKE 'user'");
        $user_table_exists = $result->rowCount() == 1;

        $result = $pdo->query("SHOW TABLES LIKE 'settings'");
        $settings_table_exists = $result->rowCount() == 1;

        $result = $pdo->query("SHOW TABLES LIKE 'cms_page_markdown'");
        $cms_page_table_markdown_exists = $result->rowCount() == 1;

        $result = $pdo->query("SHOW TABLES LIKE 'cms_page_editor'");
        $cms_page_table_editor_exists = $result->rowCount() == 1;

        // if the tables doesn't exist then create them
        if (!$user_table_exists || !$cms_page_table_markdown_exists || !$cms_page_table_editor_exists) {
            // create the user table
            $pdo->exec("CREATE TABLE IF NOT EXISTS user (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(50) NOT NULL,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                filename VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // create the settings table
            $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                font VARCHAR(50) NOT NULL,
                background_color VARCHAR(50) NOT NULL,
                header_footer_background_color VARCHAR(50) NOT NULL,
                header_footer_text_color VARCHAR(50) NOT NULL,
                text_color VARCHAR(50) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
            // create the cms_page_markdown table
            $pdo->exec("CREATE TABLE IF NOT EXISTS cms_page_markdown (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                markdown TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                user_id INT(11) UNSIGNED NOT NULL,
                CONSTRAINT `fk_user_2`
                    FOREIGN KEY (user_id)
                    REFERENCES user(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // create the cms_page_editor table
            $pdo->exec("CREATE TABLE IF NOT EXISTS cms_page_editor (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                user_id INT(11) UNSIGNED NOT NULL,
                CONSTRAINT `fk_user_3`
                    FOREIGN KEY (user_id)
                    REFERENCES user(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        }

    } catch (PDOException $err) {
        // sned error message to user
        die("Error: Could not connect. " . $err->getMessage());
    }
?>