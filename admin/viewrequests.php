<?php
session_start();

// Redirect to login if not logged in or not an Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'Admin') {
    header("location: ../auth/login.php");
    exit;
}

include('../config/db.php'); // Include the database connection

// Fetch booking requests from the database
$sql = "SELECT bookings.id, bookings.status, users.username, players.name AS player_name, players.club FROM bookings 
        JOIN users ON bookings.user_id = users.id
        JOIN players ON bookings.player_id = players.id
        ORDER BY bookings.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Requests - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>View Booking Requests</h1>
    </header>

    <section>
        <h2>Booking Requests</h2>
        <div class="request-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="request-card">
                    <h3><?php echo $row['player_name']; ?> (<?php echo $row['club']; ?>)</h3>
                    <p><strong>Booked by:</strong> <?php echo $row['username']; ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst($row['status']); ?></p>

                    <!-- Admin actions for approving or rejecting -->
                    <?php if ($row['status'] == 'pending'): ?>
                        <form action="approve_booking.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="approve">Approve</button>
                            <button type="submit" name="reject">Reject</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>

</html>