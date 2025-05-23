<?php
include 'db_connect.php';  // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $traveler_id = $_POST['traveler_id'];  // Traveler's ID
    $guide_id = $_POST['guide_id'];        // Guide's ID

    // Retrieve messages from the database
    $sql = "SELECT * FROM messages WHERE (TravelerID = ? AND GuideID = ?) OR (TravelerID = ? AND GuideID = ?) ORDER BY timestamp";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $traveler_id, $guide_id, $guide_id, $traveler_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'sender' => ($row['TravelerID'] == $traveler_id) ? 'Traveler' : 'Guide',
            'message' => $row['message'],
            'timestamp' => $row['timestamp']
        ];
    }

    echo json_encode(['status' => 'success', 'messages' => $messages]);  // Return messages as JSON

    $stmt->close();
    $conn->close();
}
?>
