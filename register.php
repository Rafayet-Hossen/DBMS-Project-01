<?php
include('config/db.php');  // Include database connection

$username = $password = $confirm_password = $role = "";
$username_err = $password_err = $confirm_password_err = $role_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs and insert user into the database
    // Similar to the code above
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>Register</h1>
    </header>

    <section>
        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>
            <span><?php echo $username_err; ?></span>

            <label for="password">Password</label>
            <input type="password" name="password" required>
            <span><?php echo $password_err; ?></span>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>
            <span><?php echo $confirm_password_err; ?></span>

            <label for="role">Role</label>
            <select name="role" required>
                <option value="User">User</option>
                <option value="Admin">Admin</option>
            </select>
            <span><?php echo $role_err; ?></span>

            <button type="submit">Register</button>
        </form>
    </section>
</body>

</html>