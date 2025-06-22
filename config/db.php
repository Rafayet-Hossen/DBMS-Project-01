<?php
$servername = "localhost";
$username = "root";    // MySQL username
$password = "Rafayet1122";        // MySQL password (empty by default in XAMPP)
$dbname = "football_transfermarket"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
