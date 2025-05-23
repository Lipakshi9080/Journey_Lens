<?php
// Start the session to verify if the traveler is logged in
session_start();

// Check if the user is logged in, if not, redirect to login/signup page
if (!isset($_SESSION['traveler_email'])) {
    header("Location: traveler_signup.php"); // Modify this if your login/signup page has a different name
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "41678mysqlpass"; // Replace with your actual password
$dbname = "traveler";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <title>Journey Lens</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap");

        :root {
            --primary-color: #6c5ce7;
            --text-dark: #0f172a;
            --text-light: #94a3b8;
            --white: #ffffff;
            --max-width: 1400px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        body {
            background: linear-gradient(to right, #884ea0);
            background-position:  center;
            background-size: cover;
            background-repeat: no-repeat;
            color: var(--text-dark);
        }

        .container {
            max-width: var(--max-width);
            margin: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Destination Section */
        .featured-destinations {
            padding: 50px;
            text-align: center;
            background-color:rgb(222, 186, 237);
        }

        .featured-destinations h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--white);
        }

        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .destination-item {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.2);
        }

        .destination-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .destination-item h3 {
            padding: 15px;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        /* Footer */
        footer {
            padding: 20px;
            background-color:  #2c3e50;
            color: var(--white);
            text-align: center;
        }

        .footer-links {
            list-style: none;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .footer-links a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .destinations-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .destinations-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">Journey Lens</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#">Deals</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </header>

        <section class="featured-destinations">
            <h2>Top Destinations On Your Way</h2>
            <div class="destinations-grid">
                <div class="destination-item">
                    <img src="https://www.himalayanwonders.com/siteblog/wp-content/uploads/2014/11/himachal-pradesh.jpg" alt="Himachal Pradesh">
                    <h3>Himachal Pradesh</h3>
                </div>
                <div class="destination-item">
                    <img src="https://content3.jdmagicbox.com/comp/leh_ladakh/q9/9999p1985.1985.230209001049.m1q9/catalogue/pangong-lake-view-point-leh-ladakh-tourist-attraction-74rrc61b9n.jpg" alt="Ladakh">
                    <h3>Ladakh</h3>
                </div>
                <div class="destination-item">
                    <img src="https://traveldudes.com/wp-content/uploads/2020/09/Kerala_Main.jpg" alt="Kerala">
                    <h3>Kerala</h3>
                </div>
                <div class="destination-item">
                    <img src="https://i.pinimg.com/736x/f5/16/32/f516325966b43007aae5ef0f9382a8a6.jpg" alt="Varanasi">
                    <h3>Varanasi</h3>
                </div>
                <div class="destination-item">
                    <img src="https://d2py10ayqu2jji.cloudfront.net/Lakshadweep.webp" alt="Lakshadweep">
                    <h3>Lakshadweep</h3>
                </div>
                <div class="destination-item">
                    <img src="https://www.indiantempletour.com/wp-content/uploads/2016/07/Rajasthan-Tour-Packages.jpg" alt="Rajasthan">
                    <h3>Rajasthan</h3>
                </div>
            </div>
        </section>

        <footer>
            <ul class="footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>
            <p>&copy; 2024 Journey Lens. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>



