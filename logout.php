<?php
// Start the session
session_start();

// Destroy the session to log out the user
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the homepage (or another page, e.g., login page)
header('Location: index.php');
exit;
?>
