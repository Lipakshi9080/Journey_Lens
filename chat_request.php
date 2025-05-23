<?php
// Start the session to verify if the traveler is logged in
session_start();

// Check if the user is logged in, if not, return an error response
if (!isset($_SESSION['traveler_email'])) {
    echo json_encode(['success' => false, 'error' => 'Traveler not logged in']);
    exit();
}

// Capture the GuideID sent via AJAX
$data = json_decode(file_get_contents('php://input'), true);
$guideID = $data['guideID'] ?? null;

// Validate that the GuideID is provided
if (!$guideID) {
    echo json_encode(['success' => false, 'error' => 'GuideID is required']);
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "41678mysqlpass"; // Replace with your actual password
$dbname = "traveler";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Get the TravelerID (from session)
$travelerEmail = $_SESSION['traveler_email'];
$sql = "SELECT TravelerID FROM travelerdetails WHERE TravelerEmail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $travelerEmail); // 's' for string
$stmt->execute();
$result = $stmt->get_result();
$traveler = $result->fetch_assoc();
$travelerID = $traveler['TravelerID'] ?? null;

if (!$travelerID) {
    echo json_encode(['success' => false, 'error' => 'Traveler not found']);
    $stmt->close();
    $conn->close();
    exit();
}

// Insert the chat request into the database (use prepared statements to avoid SQL injection)
$sql = "INSERT INTO chat_requests (TravelerID, GuideID, status) VALUES (?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $travelerID, $guideID); // 'ii' for two integers
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error inserting chat request']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
