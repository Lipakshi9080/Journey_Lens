<?php
include 'db_connect.php';

$chat_id = $_POST['chat_id'];
$guide_id = $_POST['guide_id'];
$traveler_id = $_POST['traveler_id'];

// Fetch messages from the database
$sql = "SELECT * FROM messages WHERE chat_id = '$chat_id' ORDER BY timestamp ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<div class='sender'>" . ($row['TravelerID'] == $traveler_id ? "You" : "Guide") . ":</div>";
        echo "<div class='content'>" . htmlspecialchars($row['message']) . "</div>";
        echo "<div class='timestamp'>" . $row['timestamp'] . "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No messages yet. Start the conversation!</p>";
}

$conn->close();
?>
