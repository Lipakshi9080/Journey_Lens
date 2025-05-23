<?php
$servername = "localhost";
$username = "root";   // Default MySQL username for XAMPP
$password = "41678mysqlpass"; 
$dbname = "traveler";  // Replace this with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
