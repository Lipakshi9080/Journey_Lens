<?php
// Start session
session_start();

// Check if traveler is logged in
if (!isset($_SESSION['TravelerID'])) {
    header("Location: login.php");
    exit();
}

// Get the selected destination
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['destination'])) {
    $destination = $_POST['destination'];

    // Store the selected destination in session or process it as needed
    $_SESSION['selectedDestination'] = $destination;

    // For now, you can redirect them to a page where guides for the selected destination are shown
    header("Location: guide_selection.php");
    exit();
} else {
    echo "No destination selected!";
}
?>
