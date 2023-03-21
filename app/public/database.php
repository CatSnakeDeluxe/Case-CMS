<?php
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

        $result = $pdo->query("SHOW TABLES LIKE 'cms_page'");
        $cms_page_table_exists = $result->rowCount() == 1;

        // if the tables doesn't exist then create them
        if (!$user_table_exists || !$cms_page_table_exists) {
            // create the user table
            $pdo->exec("CREATE TABLE IF NOT EXISTS user (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
            // create the cms_page table
            $pdo->exec("CREATE TABLE IF NOT EXISTS cms_page (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                text VARCHAR(255) NOT NULL,
                user_id INT(11) UNSIGNED NOT NULL,
                CONSTRAINT `fk_user`
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