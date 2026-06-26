<?php
/**
 * Logout Handler
 * Destroys user session and redirects to login page
 */

session_start();
session_destroy();

// Clear the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login page
header("Location: login.php");
exit;
?>
