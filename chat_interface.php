<?php
session_start();
include 'db_connect.php'; // Ensure this file contains the database connection code

// Ensure both TravelerID and GuideID are passed as GET parameters
if (!isset($_GET['Traveler_id']) || !isset($_GET['Guide_id'])) {
    die("Invalid access!");
}

$traveler_id = $_GET['Traveler_id'];
$guide_id = $_GET['Guide_id'];

// Fetch chat history from the 'messages' table
$sql = "SELECT * FROM messages WHERE TravelerID = ? AND GuideID = ? ORDER BY timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $traveler_id, $guide_id);
$stmt->execute();
$chat_result = $stmt->get_result();

// Get the name of the other party (Traveler or Guide)
if (isset($_SESSION['TravelerID'])) {
    $query = "SELECT GuideName FROM guidedetails WHERE GuideID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $guide_id);
} else {
    $query = "SELECT TravelerName FROM travelerdetails WHERE TravelerID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $traveler_id);
}
$stmt->execute();
$result = $stmt->get_result();
$other_party_name = $result->fetch_assoc()['GuideName'] ?? $result->fetch_assoc()['TravelerName'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .chat-container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: 80vh;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            text-align: center;
            font-size: 20px;
            color: #6c3483;
        }
        .chat-history {
            flex-grow: 1;
            overflow-y: auto;
            margin: 20px 0;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .chat-history .message {
            margin-bottom: 10px;
        }
        .chat-history .message.traveler {
            text-align: left;
            color: #2980b9;
        }
        .chat-history .message.guide {
            text-align: right;
            color: #27ae60;
        }
        .chat-form {
            display: flex;
        }
        .chat-form textarea {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none;
        }
        .chat-form button {
            background-color: #6c3483;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            Chat with <?php echo htmlspecialchars($other_party_name); ?>
        </div>
        <div class="chat-history" id="chatHistory">
            <?php while ($row = $chat_result->fetch_assoc()): ?>
                <div class="message <?php echo strtolower($row['SenderType']); ?>">
                    <strong><?php echo htmlspecialchars($row['SenderType']); ?>:</strong>
                    <?php echo htmlspecialchars($row['message']); ?>
                    <small style="display:block;font-size:12px;"><?php echo $row['timestamp']; ?></small>
                </div>
            <?php endwhile; ?>
        </div>
        <form class="chat-form" method="POST" action="send_message.php">
            <textarea name="message" rows="2" placeholder="Type your message here..." required></textarea>
            <input type="hidden" name="traveler_id" value="<?php echo $traveler_id; ?>">
            <input type="hidden" name="guide_id" value="<?php echo $guide_id; ?>">
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
