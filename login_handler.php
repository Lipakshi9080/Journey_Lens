<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "41678mysqlpass"; // Update with your actual password
$dbname = "traveler";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['TravelerEmail'];
    $contact = $_POST['TravelerContact'];

    // Query to check if the traveler exists
    $sql = "SELECT * FROM travelerdetails WHERE TravelerEmail = ? AND TravelerContact = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Traveler exists, start session
        $row = $result->fetch_assoc();
        $_SESSION['traveler_email'] = $row['TravelerEmail'];
        $_SESSION['traveler_name'] = $row['TravelerName'];

        // Redirect to destination page
        header("Location: destination.php");
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Invalid email or contact number.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p style='color: red; text-align: center;'>Invalid request method.</p>";
}
?>
