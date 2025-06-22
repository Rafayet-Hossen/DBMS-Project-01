<?php
session_start(); // Start the session to check if the user is logged in

include('includes/header.php');  // Include the navbar
include('config/db.php');        // Include the database connection

// Fetch players from the database
$sql = "SELECT * FROM players ORDER BY created_at DESC";
$result = $conn->query($sql);

// Initialize modal flag
$show_modal = false;

// Handle the booking request when "Book Now" is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_player'])) {
    $player_id = $_POST['player_id'];
    $user_id = $_SESSION['id'];

    // Insert booking request into bookings table
    $sql = "INSERT INTO bookings (user_id, player_id) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $user_id, $player_id);
        if ($stmt->execute()) {
            $show_modal = true;  // Set modal flag to true on success
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Transfermarket Bangladesh</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <section>
        <h2>Trending Players</h2>
        <div id="player-cards">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="player-card">
                    <h3><?php echo $row["name"]; ?></h3>
                    <p><strong>Club:</strong> <?php echo $row["club"]; ?></p>
                    <p><strong>Price:</strong> <?php echo $row["price"]; ?> BDT</p>
                    <p><strong>Goals:</strong> <?php echo $row["goals"]; ?></p>
                    <p><strong>Assists:</strong> <?php echo $row["assists"]; ?></p>
                    <p><strong>Position:</strong> <?php echo $row["position"]; ?></p>

                    <!-- Book Now Button (Only show if user is logged in) -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'User'): ?>
                        <form action="index.php" method="POST">
                            <input type="hidden" name="player_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="book_player">Book Now</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Success Modal -->
    <?php if ($show_modal): ?>
        <div class="modal" id="successModal" style="display: block;">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
                <h2>Booking Request Submitted!</h2>
                <p>Your booking request has been successfully submitted. It will be reviewed by the admin.</p>
                <a href="index.php" class="btn">Go to Home</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal Style -->
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* Semi-transparent background */
            padding-top: 60px;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
            border-radius: 8px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</body>

</html>