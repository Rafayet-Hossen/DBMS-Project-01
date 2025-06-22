<?php
include('includes/header.php');  // Include the navbar
include('config/db.php');        // Include the database connection

// Fetch players from the database
$sql = "SELECT * FROM players ORDER BY created_at DESC";  // This will order by the 'created_at' column
$result = $conn->query($sql);
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
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>

</html>