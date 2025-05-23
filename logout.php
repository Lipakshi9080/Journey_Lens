<?php
// Start the session
session_start();

// Destroy the session
session_unset();  // Unsets all session variables
session_destroy();  // Destroys the session

// Redirect to the login page (or homepage)
header("Location: traveler_signup.php");  // Change this to wherever you want to redirect
exit();
?>
