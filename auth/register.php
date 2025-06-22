<?php
session_start();
include('../config/db.php'); // Include database connection

// Initialize variables
$username = $password = $confirm_password = $role = "";
$username_err = $password_err = $confirm_password_err = $role_err = "";

// Flag for showing success modal
$show_modal = false;

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Passwords do not match.";
        }
    }

    if (empty($_POST['role'])) {
        $role_err = "Please select a role.";
    } else {
        $role = $_POST['role'];
    }

    // Check for input errors before inserting into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);  // Hash password

        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_password, $param_role);

            // Set parameters
            $param_username = $username;
            $param_password = $password_hash;
            $param_role = $role;

            if ($stmt->execute()) {
                // Set flag to show success modal
                $show_modal = true;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Football Transfermarket Bangladesh</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Register for Football Transfermarket Bangladesh</h1>
    </header>

    <section>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>" required>
                <span class="error"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <span class="error"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="User" <?php echo ($role == 'User' ? 'selected' : ''); ?>>User</option>
                    <option value="Admin" <?php echo ($role == 'Admin' ? 'selected' : ''); ?>>Admin</option>
                </select>
                <span class="error"><?php echo $role_err; ?></span>
            </div>

            <div class="form-group">
                <button type="submit">Register</button>
            </div>

            <div class="form-group">
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
        </form>
    </section>

    <!-- Success Modal (visible if registration is successful) -->
    <?php if ($show_modal): ?>
        <div class="modal" id="successModal" style="display: block;">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
                <h2>Registration Successful!</h2>
                <p>Your account has been successfully created. You can now log in using your credentials.</p>
                <a href="login.php" class="btn">Go to Login</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal Style -->
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
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