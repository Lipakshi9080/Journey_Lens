<?php
// Include the database connection file
include 'db_connect.php';

// Retrieve the chat ID, traveler ID, and guide ID from the POST request
$chat_id = $_POST['chat_id'];
$traveler_id = $_POST['traveler_id'];
$guide_id = $_POST['guide_id'];

// Update the chat status to 'archived' for the given chat_id
$sql = "UPDATE conversations SET chat_status = 'archived' WHERE ConversationID = '$chat_id' AND TravelerID = '$traveler_id' AND GuideID = '$guide_id'";

// Check if the query was successful
if ($conn->query($sql) === TRUE) {
    echo "Chat ended and archived successfully!";
} else {
    echo "Error archiving chat: " . $conn->error;
}

// Close the connection
$conn->close();
?>
