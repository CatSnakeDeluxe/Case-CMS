<?php
    session_start();
    
    // clear session data
    session_unset();
    session_destroy();

    // prepare session for success message
    session_start();
    $_SESSION['message'] = "Sucessfully logged out";
    
    // redirect user to login page
    header('location: login.php');
    exit();
?>