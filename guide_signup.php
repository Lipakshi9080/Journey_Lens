<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "41678mysqlpass"; // Replace with your database password
$dbname = "traveler";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$signupMsg = "";
$loginMsg = "";

// Handle Signup Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signup'])) {
    $guideName = $_POST['GuideName'];
    $guideAge = $_POST['GuideAge'];
    $guideGender = $_POST['GuideGender'];
    $guideEmail = $_POST['GuideEmail'];
    $guideContact = $_POST['GuideContact'];
    $guideState = $_POST['GuideState'];
    $guideCity = $_POST['GuideCity'];

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM guidedetails WHERE GuideEmail = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $guideEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $signupMsg = "Email already exists. Please login.";
    } else {
        // Proceed with signup
        $sql = "INSERT INTO guidedetails (GuideName, GuideAge, GuideGender, GuideEmail, GuideContact, GuideState, GuideCity) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssss", $guideName, $guideAge, $guideGender, $guideEmail, $guideContact, $guideState, $guideCity);

        if ($stmt->execute()) {
            $signupMsg = "Signup successful! Please log in.";
        } else {
            $signupMsg = "Error during signup: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle Login Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $guideEmail = $_POST['GuideEmail'];
    $guideContact = $_POST['GuideContact'];

    $sql = "SELECT * FROM guidedetails WHERE GuideEmail = ? AND GuideContact = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $guideEmail, $guideContact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $guide = $result->fetch_assoc();
        $_SESSION['GuideID'] = $guide['GuideID']; // Store GuideID in session
        $_SESSION['GuideEmail'] = $guideEmail;
        header("Location: guide_dashboard.php"); // Redirect to guide dashboard
        exit(); // Prevent further execution
    } else {
        $loginMsg = "Invalid email or contact. Please try again.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Signup/Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgba(176, 129, 188, 0.87);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 500px;
        }
        .toggle-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .toggle-buttons button {
            background-color: #af7ac5;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }
        .toggle-buttons button.active {
            background-color: #9c6bb0;
        }
        .form-container {
            display: none; /* Forms hidden by default */
        }
        .form-container.active {
            display: block; /* Active form is visible */
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .input-group label {
            font-size: 14px;
            color: #555;
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn {
            background-color: #af7ac5;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #9c6bb0;
        }
        .message {
            margin: 10px 0;
            color: green;
            font-size: 14px;
        }
        .h1 {
            color: #6c3483;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Welcome to Guide Portal</h1>
        <p>Signup or Login as Guide</p>
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button id="signup-btn">Sign Up</button>
            <button id="login-btn">Login</button>
        </div>

        <!-- Signup Form -->
        <div id="signup-form" class="form-container">
            <?php if (!empty($signupMsg)) echo "<p class='message'>$signupMsg</p>"; ?>
            <form method="POST">
                <div class="input-group">
                    <label for="GuideName">Guide Name</label>
                    <input type="text" id="GuideName" name="GuideName" placeholder="Enter your name" required>
                </div>
                <div class="input-group">
                    <label for="GuideAge">Guide Age</label>
                    <input type="number" id="GuideAge" name="GuideAge" placeholder="Enter your age" required>
                </div>
                <div class="input-group">
                    <label for="GuideGender">Guide Gender</label>
                    <select id="GuideGender" name="GuideGender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="GuideEmail">Guide Email</label>
                    <input type="email" id="GuideEmail" name="GuideEmail" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="GuideContact">Guide Contact</label>
                    <input type="text" id="GuideContact" name="GuideContact" placeholder="Enter your contact number" required>
                </div>
                <div class="input-group">
                    <label for="GuideState">Guide State</label>
                    <input type="text" id="GuideState" name="GuideState" placeholder="Enter state name" required>
                </div>
                <div class="input-group">
                    <label for="GuideCity">Guide City</label>
                    <input type="text" id="GuideCity" name="GuideCity" placeholder="Enter city name" required>
                </div>
                <button type="submit" name="signup" class="btn">Sign Up</button>
            </form>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-container">
            <?php if (!empty($loginMsg)) echo "<p class='message'>$loginMsg</p>"; ?>
            <form method="POST">
                <div class="input-group">
                    <label for="GuideEmail">Email</label>
                    <input type="email" id="GuideEmail" name="GuideEmail" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="GuideContact">Contact Number</label>
                    <input type="text" id="GuideContact" name="GuideContact" placeholder="Enter your contact number" required>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle between Signup and Login forms
        const signupBtn = document.getElementById("signup-btn");
        const loginBtn = document.getElementById("login-btn");
        const signupForm = document.getElementById("signup-form");
        const loginForm = document.getElementById("login-form");

        signupBtn.addEventListener("click", () => {
            signupForm.classList.add("active");
            loginForm.classList.remove("active");
            signupBtn.classList.add("active");
            loginBtn.classList.remove("active");
        });

        loginBtn.addEventListener("click", () => {
            loginForm.classList.add("active");
            signupForm.classList.remove("active");
            loginBtn.classList.add("active");
            signupBtn.classList.remove("active");
        });
    </script>
</body>
</html>
