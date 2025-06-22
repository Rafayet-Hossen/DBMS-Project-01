<?php
// Start the session
session_start();

// Unset all session variables to log the user out
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("location: login.php");
exit;
