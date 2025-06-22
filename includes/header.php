<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}
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
                <!-- If Admin, show the "Add Player" and "View Requests" links -->
                <?php if ($_SESSION['role'] == 'Admin'): ?>
                    <li><a href="admin/dashboard.php">Add Player</a></li>
                    <li><a href="admin/viewrequests.php">View Requests</a></li>
                <?php endif; ?>

                <!-- Logout button for logged-in users -->
                <li><a href="auth/logout.php">Logout</a></li>
            <?php else: ?>
                <!-- Login button for non-logged-in users -->
                <li><a href="auth/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>