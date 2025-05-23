<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state = $_POST['state'] ?? '';
    $city = $_POST['city'] ?? '';

    // Validate inputs
    if (!empty($state) && !empty($city)) {
        // Store state and city in session to pass to guide_list.php
        session_start();
        $_SESSION['state'] = $state;
        $_SESSION['city'] = $city;

        // Redirect to guide_list.php
        header("Location: guide_list.php");
        exit();
    } else {
        $error = "Please fill out both state and city.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Destination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #bb8fce;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            height:300px;
            width: 100%;
        }
        .container h2 {
            margin-bottom: 30px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background-color:rgb(96, 19, 138);
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn:hover {
            background-color:rgb(110, 0, 179);
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Your Travel Destination</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="state">State:</label>
            <input type="text" id="state" name="state" placeholder="Enter state" required>
            
            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="Enter city" required>
            
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>
</html>
