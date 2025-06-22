<?php
session_start(); // Start the session to check if user is logged in
?>

<header>
    <div class="logo">
        <img src="assets/images/logo.png" alt="Football Transfermarket Logo" width="150px"> <!-- Your logo here -->
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="user/tournaments.php">Tournaments</a></li>
            <li><a href="user/top_rated_players.php">Top Rated Players</a></li>

            <?php if (isset($_SESSION['role'])): ?>
                <li><a href="auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>