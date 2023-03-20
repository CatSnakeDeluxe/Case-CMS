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

} catch (PDOException $err) {
    // sned error message to user
    die("Error: Could not connect. " . $err->getMessage());
}
?>

<!-- 
LINODE
$db_host = "localhost"; // usually: localhost
$db_name = "cms";
$db_user = "cms_user_linode";
$db_password = "ZY3eDmRchz"; 
-->