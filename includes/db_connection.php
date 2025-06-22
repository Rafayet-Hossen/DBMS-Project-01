<?php
$servername = "localhost";
$username = "root";
$password = "Rafayet1122";
$dbname = "football_transfermarket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
