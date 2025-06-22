<?php
session_start();

// Redirect to login if not logged in or not an Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'Admin') {
    header("location: ../auth/login.php");
    exit;
}

include('../config/db.php'); // Include the database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Football Transfermarket Bangladesh</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <section>
        <h2>Welcome, Admin</h2>

        <!-- Button to redirect to Add Player page -->
        <a href="addplayer.php" class="btn">Add Player</a>

        <!-- Other Dashboard Content -->
        <div class="dashboard-content">
            <!-- Other content for the admin dashboard goes here -->
        </div>
    </section>
</body>

</html>