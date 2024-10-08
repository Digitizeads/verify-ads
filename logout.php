<?php
session_start(); // Start the session

// Destroy the session to log the user out
$_SESSION = []; // Clear all session variables
session_destroy(); // Destroy the session

header('Location: admin'); // Redirect to login page after logout
exit();
?>