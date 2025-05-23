<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "41678mysqlpass"; // Replace with your actual password
$dbname = "traveler";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read the incoming data
$data = json_decode(file_get_contents("php://input"), true);

$travelerID = $data['travelerID'];
$guideID = $data['guideID'];
$message = $data['message'];

// Generate a unique chat_id based on TravelerID and GuideID
$chat_id = md5($travelerID . '-' . $guideID);

// Insert the message into the messages table
$sql = "INSERT INTO messages (chat_id, TravelerID, GuideID, message) VALUES ('$chat_id', '$travelerID', '$guideID', '$message')";

if ($conn->query($sql) === TRUE) {
    // Respond with success
    echo json_encode(['success' => true]);
} else {
    // Respond with error
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
