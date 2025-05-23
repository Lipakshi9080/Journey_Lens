<?php
// Start the session to verify if the traveler is logged in
session_start();

// Check if the traveler is logged in
if (!isset($_SESSION['traveler_email'])) {
    header("Location: traveler_signup.php"); // Redirect to login/signup page
    exit();
}

// Retrieve the required parameters from the URL
if (isset($_GET['chat_id']) && isset($_GET['GuideID']) && isset($_GET['TravelerID'])) {
    $ChatID = $_GET['chat_id'];
    $GuideID = $_GET['GuideID'];
    $TravelerID = $_GET['TravelerID'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "41678mysqlpass"; // Replace with your actual password
    $dbname = "traveler"; // Your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch previous messages
    $message_sql = "SELECT * FROM messages WHERE chat_id = '$ChatID' ORDER BY timestamp ASC";
    $messages_result = $conn->query($message_sql);

    // Close the connection
    $conn->close();
} else {
    echo "Invalid conversation details.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        .chat-box {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 400px;
            overflow-y: scroll;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background-color: #e0e0e0;
        }

        .message .sender {
            font-weight: bold;
        }

        .message .content {
            margin-top: 5px;
        }

        .message .timestamp {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .input-area {
            display: flex;
            margin-top: 20px;
        }

        .input-area textarea {
            width: 90%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .input-area button {
            padding: 10px 15px;
            margin-left: 10px;
            background-color: #6c5ce7;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .input-area button:hover {
            background-color: #5a47d3;
        }

        /* End chat button */
        .end-chat {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Chat with Guide</h2>

<div class="chat-box">
    <?php
    // Display the previous messages from the conversation
    if ($messages_result->num_rows > 0) {
        while ($row = $messages_result->fetch_assoc()) {
            echo "<div class='message'>";
            echo "<div class='sender'>" . ($row['TravelerID'] == $TravelerID ? "You" : "Guide") . ":</div>";
            echo "<div class='content'>" . htmlspecialchars($row['message']) . "</div>";
            echo "<div class='timestamp'>" . $row['timestamp'] . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No messages yet. Start the conversation!</p>";
    }
    ?>
</div>

<div class="input-area">
    <textarea id="message" placeholder="Type your message here..."></textarea>
    <button onclick="sendMessage()">Send</button>
</div>

<!-- End Chat Button -->
<div class="end-chat">
    <button onclick="endChat()">End Chat</button>
</div>

<script>
    // Function to send a new message
    function sendMessage() {
        var message = document.getElementById("message").value;
        if (message.trim() !== "") {
            // Send the message using AJAX (we will create an AJAX script to handle this)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_message.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // If message sent successfully, reload the chat to display the new message
                    document.location.reload();
                }
            };
            xhr.send("chat_id=<?php echo $ChatID; ?>&GuideID=<?php echo $GuideID; ?>&TravelerID=<?php echo $TravelerID; ?>&message=" + encodeURIComponent(message));
            document.getElementById("message").value = ""; // Clear the input field
        } else {
            alert("Please enter a message.");
        }
    }

    // Function to end the chat
    function endChat() {
        var chat_id = <?php echo $ChatID; ?>;
        var traveler_id = <?php echo $TravelerID; ?>;
        var guide_id = <?php echo $GuideID; ?>;

        // Send AJAX request to end the chat
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "end_chat.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                window.location.href = "chat_history.php";  // Redirect to chat history page
            }
        };
        xhr.send("chat_id=" + chat_id + "&traveler_id=" + traveler_id + "&guide_id=" + guide_id);
    }
</script>

</body>
</html>

