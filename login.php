<?php
include('config/db.php');  // Include database connection

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username and password, check login credentials from DB
    // Similar to the code above
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>Login</h1>
    </header>

    <section>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>
            <span><?php echo $username_err; ?></span>

            <label for="password">Password</label>
            <input type="password" name="password" required>
            <span><?php echo $password_err; ?></span>

            <button type="submit">Login</button>
        </form>
    </section>
</body>

</html>