<?php
include 'db_connect.php';
session_start();

if (isset($_GET['guide_id']) && isset($_GET['traveler_id'])) {
    $guide_id = $_GET['guide_id'];
    $traveler_id = $_GET['traveler_id'];

    if (!is_numeric($guide_id) || !is_numeric($traveler_id)) {
        die("Invalid parameters. Please select a guide from the guide list.");
    }

    $stmt = $conn->prepare("SELECT 1 FROM guidedetails WHERE GuideID = ?");
    $stmt->bind_param("i", $guide_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        die("Guide not found.");
    }

    $stmt = $conn->prepare("SELECT 1 FROM travelerdetails WHERE TravelerID = ?");
    $stmt->bind_param("i", $traveler_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        die("Traveler not found.");
    }

    $query = "
        SELECT * FROM messages 
        WHERE (GuideID = ? AND TravelerID = ?) 
        ORDER BY Timestamp";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $guide_id, $traveler_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Missing required parameters. Please select a guide from the guide list.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Room</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .chat-container {
            width: 100%;
            max-width: 800px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .message-container {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
            height: 400px;
        }
        .message {
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            max-width: 70%;
        }
        .message span {
            font-weight: bold;
            color: #2b6a7e;
        }
        .message .message-content {
            margin-top: 5px;
            font-size: 1em;
            color: #444;
        }
        .message.traveler {
            background-color: #e1f7d5;
            align-self: flex-start;
        }
        .message.guide {
            background-color: #d6e5f3;
            align-self: flex-end;
        }
        .input-container {
            display: flex;
            align-items: center;
        }
        .input-container input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            margin-right: 10px;
            background-color: #fafafa;
        }
        .input-container button {
            background-color: #6d21e0;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        .input-container button:hover {
            background-color: #5817c3;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <h2>Chat with Guide</h2>

    <!-- Message Display -->
    <div class="message-container" id="chat-box">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="message <?php echo ($row['Sender'] == 'Traveler') ? 'traveler' : 'guide'; ?>">
                <span><?php echo htmlspecialchars($row['Sender']); ?>:</span>
                <div class="message-content"><?php echo htmlspecialchars($row['Message']); ?></div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Message Input -->
    <div class="input-container">
        <input type="text" id="messageInput" placeholder="Type your message..." required>
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<!-- Socket.IO Client -->
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
<script>
    const travelerId = <?php echo $traveler_id; ?>;
    const guideId = <?php echo $guide_id; ?>;
    const senderRole = "<?php echo isset($_SESSION['GuideID']) ? 'Guide' : 'Traveler'; ?>";
    const roomId = `room_${Math.min(travelerId, guideId)}_${Math.max(travelerId, guideId)}`;

    const socket = io("http://localhost:3000"); // Replace with your Node server IP if not localhost

    socket.emit("joinRoom", roomId);

    function sendMessage() {
        const message = document.getElementById("messageInput").value.trim();
        if (message === "") return;

        const msgData = {
            roomId: roomId,
            guideId: guideId,
            travelerId: travelerId,
            sender: senderRole,
            message: message
        };

        socket.emit("sendMessage", msgData);
        document.getElementById("messageInput").value = "";
    }

    socket.on("receiveMessage", function (data) {
        const chatBox = document.getElementById("chat-box");
        const msgDiv = document.createElement("div");
        msgDiv.classList.add("message", data.sender === "Traveler" ? "traveler" : "guide");

        msgDiv.innerHTML = `
            <span>${data.sender}:</span>
            <div class="message-content">${data.message}</div>
        `;
        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>

</body>
</html>
