<?php
session_start();

// Redirect to login if not logged in or not an Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'Admin') {
    header("location: ../auth/login.php");
    exit;
}

include('../config/db.php'); // Include the database connection

// Initialize variables
$name = $age = $club = $country = $goals = $assists = $position = $price = "";
$name_err = $age_err = $club_err = $country_err = $goals_err = $assists_err = $position_err = $price_err = "";

// Flag for modal success message
$show_modal = false;

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the player's name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["age"]))) {
        $age_err = "Please enter the player's age.";
    } else {
        $age = trim($_POST["age"]);
    }

    if (empty(trim($_POST["club"]))) {
        $club_err = "Please enter the player's club.";
    } else {
        $club = trim($_POST["club"]);
    }

    if (empty(trim($_POST["country"]))) {
        $country_err = "Please enter the player's country.";
    } else {
        $country = trim($_POST["country"]);
    }

    if (empty(trim($_POST["goals"]))) {
        $goals_err = "Please enter the number of goals.";
    } else {
        $goals = trim($_POST["goals"]);
    }

    if (empty(trim($_POST["assists"]))) {
        $assists_err = "Please enter the number of assists.";
    } else {
        $assists = trim($_POST["assists"]);
    }

    if (empty(trim($_POST["position"]))) {
        $position_err = "Please enter the player's position.";
    } else {
        $position = trim($_POST["position"]);
    }

    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter the player's price.";
    } else {
        $price = trim($_POST["price"]);
    }

    // If no errors, insert the player into the database
    if (empty($name_err) && empty($age_err) && empty($club_err) && empty($country_err) && empty($goals_err) && empty($assists_err) && empty($position_err) && empty($price_err)) {
        $sql = "INSERT INTO players (name, age, club, country, goals, assists, position, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sisssssd", $param_name, $param_age, $param_club, $param_country, $param_goals, $param_assists, $param_position, $param_price);

            // Set parameters
            $param_name = $name;
            $param_age = $age;
            $param_club = $club;
            $param_country = $country;
            $param_goals = $goals;
            $param_assists = $assists;
            $param_position = $position;
            $param_price = $price;

            if ($stmt->execute()) {
                // Show modal on successful player addition
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
    <title>Add Player - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
        <h1>Add a New Player</h1>
    </header>

    <section>
        <form action="addplayer.php" method="POST">
            <div class="form-group">
                <label for="name">Player Name</label>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
                <span class="error"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group">
                <label for="age">Player Age</label>
                <input type="number" name="age" id="age" value="<?php echo $age; ?>" required>
                <span class="error"><?php echo $age_err; ?></span>
            </div>

            <div class="form-group">
                <label for="club">Player Club</label>
                <input type="text" name="club" id="club" value="<?php echo $club; ?>" required>
                <span class="error"><?php echo $club_err; ?></span>
            </div>

            <div class="form-group">
                <label for="country">Player Country</label>
                <input type="text" name="country" id="country" value="<?php echo $country; ?>" required>
                <span class="error"><?php echo $country_err; ?></span>
            </div>

            <div class="form-group">
                <label for="goals">Goals Scored</label>
                <input type="number" name="goals" id="goals" value="<?php echo $goals; ?>" required>
                <span class="error"><?php echo $goals_err; ?></span>
            </div>

            <div class="form-group">
                <label for="assists">Assists</label>
                <input type="number" name="assists" id="assists" value="<?php echo $assists; ?>" required>
                <span class="error"><?php echo $assists_err; ?></span>
            </div>

            <div class="form-group">
                <label for="position">Player Position</label>
                <input type="text" name="position" id="position" value="<?php echo $position; ?>" required>
                <span class="error"><?php echo $position_err; ?></span>
            </div>

            <div class="form-group">
                <label for="price">Player Price (in BDT)</label>
                <input type="number" name="price" id="price" value="<?php echo $price; ?>" required>
                <span class="error"><?php echo $price_err; ?></span>
            </div>

            <div class="form-group">
                <button type="submit">Add Player</button>
            </div>
        </form>
    </section>

    <!-- Success Modal (visible if player is added successfully) -->
    <?php if ($show_modal): ?>
        <div class="modal" id="successModal" style="display: block;">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('successModal').style.display='none'">&times;</span>
                <h2>Player Added Successfully!</h2>
                <p>The player has been added successfully. You will be redirected to the home page.</p>
                <a href="../index.php" class="btn">Go to Home</a>
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