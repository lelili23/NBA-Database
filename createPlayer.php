<?php

include 'config.php';

$fname = $lname = $position = $team_id = $height = $weight = $age = $salary = "";
$fname_err = $lname_err = $position_err = $team_id_err = $height_err = $weight_err = $age_err = $salary_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate all inputs
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter the first name.";
    } else {
        $fname = mysqli_real_escape_string($link, $_POST["fname"]);
    }

    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter the last name.";
    } else {
        $lname = mysqli_real_escape_string($link, $_POST["lname"]);
    }

    if (empty(trim($_POST["position"]))) {
        $position_err = "Please enter the player's position.";
    } else {
        $position = mysqli_real_escape_string($link, $_POST["position"]);
    }

    if (empty($_POST["team_id"])) {
        $team_id_err = "Please select a team.";
    } else {
        $team_id = mysqli_real_escape_string($link, $_POST["team_id"]);
    }

    if (empty($_POST["height"])) {
        $height_err = "Please enter the height.";
    } else {
        $height = mysqli_real_escape_string($link, $_POST["height"]);
    }

    if (empty($_POST["weight"])) {
        $weight_err = "Please enter the weight.";
    } else {
        $weight = mysqli_real_escape_string($link, $_POST["weight"]);
    }

    if (empty($_POST["age"])) {
        $age_err = "Please enter the age.";
    } else {
        $age = mysqli_real_escape_string($link, $_POST["age"]);
    }

    if (empty($_POST["salary"])) {
        $salary_err = "Please enter the salary.";
    } else {
        $salary = mysqli_real_escape_string($link, $_POST["salary"]);
    }

    // Attempt to insert into database
    if (empty($fname_err) && empty($lname_err) && empty($position_err) && empty($team_id_err) && 
        empty($height_err) && empty($weight_err) && empty($age_err) && empty($salary_err)) {

        $sql = "INSERT INTO Players (fname, lname, position, team_id, height, weight, age, salary) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssiiiii", $fname, $lname, $position, $team_id, $height, $weight, $age, $salary);

            if (mysqli_stmt_execute($stmt)) {
                echo "New player created successfully!";
            } else {
                echo "Error: Could not execute the query.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Could not prepare the query.";
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <title>NBA Database</title>
</head>
<body>
<a href="index.php">
    <button>Go to Home Page</button>
</a> 

<h1>Create New Player</h1>

<form action="createPlayer.php" method="post">
    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" required>
    <span><?php echo $fname_err; ?></span><br>

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" required>
    <span><?php echo $lname_err; ?></span><br>

    <label for="position">Position:</label>
    <input type="text" id="position" name="position" value="<?php echo $position; ?>" required>
    <span><?php echo $position_err; ?></span><br>

    <label for="team_id">Team ID:</label>
    <input type="number" id="team_id" name="team_id" value="<?php echo $team_id; ?>" required>
    <span><?php echo $team_id_err; ?></span><br>

    <label for="height">Height (in):</label>
    <input type="number" id="height" name="height" value="<?php echo $height; ?>" required>
    <span><?php echo $height_err; ?></span><br>

    <label for="weight">Weight (lb):</label>
    <input type="number" id="weight" name="weight" value="<?php echo $weight; ?>" required>
    <span><?php echo $weight_err; ?></span><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
    <span><?php echo $age_err; ?></span><br>

    <label for="salary">Salary:</label>
    <input type="number" step="0.01" id="salary" name="salary" value="<?php echo $salary; ?>" required>
    <span><?php echo $salary_err; ?></span><br>

    <input type="submit" value="Create Player">
</form>

</body>
</html>
