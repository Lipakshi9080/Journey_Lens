<?php
include 'db_connect.php';
session_start();

// Ensure the guide is logged in
if (!isset($_SESSION['GuideID'])) {
    die("You must log in as a guide to access this page.");
}

$guide_id = $_SESSION['GuideID']; // Assuming guide's ID is stored in session

// Fetch all travelers who have started a chat or have queries for the guide
$query = "SELECT td.TravelerID, td.TravelerName, td.TravelerCity FROM travelerdetails td 
          JOIN chat_sessions cs ON td.TravelerID = cs.TravelerID 
          WHERE cs.GuideID = ?"; // Assuming there's a chat_sessions table storing active chat sessions
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Dashboard</title>
    <style>
        /* Add CSS styling for the guide dashboard */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .chat-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .chat-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome, Guide</h2>
        </div>
        <h3>Active Chat Sessions:</h3>
        <table>
            <thead>
                <tr>
                    <th>Traveler Name</th>
                    <th>City</th>
                    <th>Start Chat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['TravelerName']) . "</td>
                                <td>" . htmlspecialchars($row['TravelerCity']) . "</td>
                                <td><a href='chatroom.php?guide_id=$guide_id&traveler_id=" . $row['TravelerID'] . "' class='chat-button'>Start Chat</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No active chats available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
