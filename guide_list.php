<?php
include 'db_connect.php';
session_start();

// Retrieve state and city from session
$state = $_SESSION['state'] ?? '';
$city = $_SESSION['city'] ?? '';
$traveler_id = $_SESSION['TravelerID'] ?? ''; // Assuming TravelerID is stored in session

if (empty($state) || empty($city)) {
    die("No destination selected. Please go back and select your travel destination.");
}

// Check if traveler ID exists in session, otherwise redirect or handle error
if (empty($traveler_id)) {
    die("No traveler session found. Please log in.");
}

// Fetch guides based on the selected city
$query = "
    SELECT 
        g.GuideID, 
        g.GuideName, 
        g.GuideAge, 
        g.GuideGender, 
        g.GuideContact, 
        g.GuideEmail, 
        g.GuideCity, 
        AVG(r.Rating) AS AvgRating, 
        COUNT(r.ReviewID) AS ReviewCount 
    FROM guidedetails g
    LEFT JOIN guidereview r ON g.GuideID = r.GuideID
    WHERE g.GuideCity = ?
    GROUP BY g.GuideID
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $city);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #bb8fce;
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
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .guide-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fdfdfd;
        }
        .guide-card h3 {
            margin: 0;
            color:rgb(157, 0, 255);
        }
        .guide-info {
            margin: 10px 0;
        }
        .guide-info span {
            font-weight: bold;
        }
        .btn {
            background-color:rgb(134, 41, 201);
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn:hover {
            background-color:rgb(93, 9, 131);
        }
        .rating {
            color: #ffc107;
            font-weight: bold;
        }
        .review-count {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Guides in <?php echo htmlspecialchars($city); ?></h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="guide-card">
                <h3><?php echo htmlspecialchars($row['GuideName']); ?></h3>
                <div class="guide-info">
                    <span>Age:</span> <?php echo htmlspecialchars($row['GuideAge']); ?> |
                    <span>Gender:</span> <?php echo htmlspecialchars($row['GuideGender']); ?>
                </div>
                <div class="guide-info">
                    <span>Contact:</span> <?php echo htmlspecialchars($row['GuideContact']); ?> |
                    <span>Email:</span> <?php echo htmlspecialchars($row['GuideEmail']); ?>
                </div>
                <div class="guide-info">
                    <span>City:</span> <?php echo htmlspecialchars($row['GuideCity']); ?>
                </div>
                <div class="guide-info">
                    <span>Rating:</span>
                    <span class="rating"><?php echo number_format($row['AvgRating'] ?? 0, 2); ?></span> 
                    (<?php echo $row['ReviewCount'] ?? 0; ?> reviews)
                </div>
                <!-- Start Chat Button -->
                <form action="chatroom.php" method="GET">
                    <input type="hidden" name="guide_id" value="<?php echo $row['GuideID']; ?>">
                    <input type="hidden" name="traveler_id" value="<?php echo $traveler_id; ?>">
                    <button type="submit" class="btn">Start Chat</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
