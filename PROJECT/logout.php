<?php
session_start();

// 1. Clear all session data (User ID, Name, etc.)
$_SESSION = array();

// 2. Destroy the session on the server
session_destroy();

// 3. Redirect to the login page
header("Location: home.php?msg=You have been logged out.");
exit();
?>