<?php
session_start();

// Redirect to login if not logged in or not an Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'Admin') {
    header("location: ../auth/login.php");
    exit;
}

include('../config/db.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $status = isset($_POST['approve']) ? 'approved' : 'rejected';

    // Update the status of the booking
    $sql = "UPDATE bookings SET status = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $status, $booking_id);

        if ($stmt->execute()) {
            echo "<script>alert('Booking status updated successfully'); window.location.href='viewrequests.php';</script>";
        } else {
            echo "Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
    $conn->close();
}
