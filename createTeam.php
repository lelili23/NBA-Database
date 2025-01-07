<?php

include 'config.php';

$name = $coach_fname = $coach_lname = $home_city = $mascot = "";
$name_err = $coach_fname_err = $coach_lname_err = $home_city_err = $mascot_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate all inputs
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a team name.";
    } else {
        $name = mysqli_real_escape_string($link, trim($_POST["name"]));
    }

    if (empty(trim($_POST["coach_fname"]))) {
        $coach_fname_err = "Please enter the coach's first name.";
    } else {
        $coach_fname = mysqli_real_escape_string($link, trim($_POST["coach_fname"]));
    }

    if (empty(trim($_POST["coach_lname"]))) {
        $coach_lname_err = "Please enter the coach's last name.";
    } else {
        $coach_lname = mysqli_real_escape_string($link, trim($_POST["coach_lname"]));
    }

    if (empty(trim($_POST["home_city"]))) {
        $home_city_err = "Please enter the home city.";
    } else {
        $home_city = mysqli_real_escape_string($link, trim($_POST["home_city"]));
    }

    if (empty(trim($_POST["mascot"]))) {
        $mascot_err = "Please enter the mascot.";
    } else {
        $mascot = mysqli_real_escape_string($link, trim($_POST["mascot"]));
    }

    // Attempt to insert into database
    if (empty($name_err) && empty($coach_fname_err) && empty($coach_lname_err) && empty($home_city_err) && empty($mascot_err)) {
        $sql = "INSERT INTO Teams (name, coach_fname, coach_lname, home_city, mascot) VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $name, $coach_fname, $coach_lname, $home_city, $mascot);

            if (mysqli_stmt_execute($stmt)) {
                echo "New team created successfully!";
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
    <title>NBA Database</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    
<a href="index.php">
    <button>Go to Home Page</button>
</a> 

<h1>Create New Team</h1>

<form action="createTeam.php" method="post">
    <label for="name">Team Name:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <span><?php echo $name_err; ?></span><br>

    <label for="coach_fname">Coach First Name:</label>
    <input type="text" id="coach_fname" name="coach_fname" value="<?php echo htmlspecialchars($coach_fname); ?>">
    <span><?php echo $coach_fname_err; ?></span><br>

    <label for="coach_lname">Coach Last Name:</label>
    <input type="text" id="coach_lname" name="coach_lname" value="<?php echo htmlspecialchars($coach_lname); ?>">
    <span><?php echo $coach_lname_err; ?></span><br>

    <label for="home_city">Home City:</label>
    <input type="text" id="home_city" name="home_city" value="<?php echo htmlspecialchars($home_city); ?>">
    <span><?php echo $home_city_err; ?></span><br>

    <label for="mascot">Mascot:</label>
    <input type="text" id="mascot" name="mascot" value="<?php echo htmlspecialchars($mascot); ?>">
    <span><?php echo $mascot_err; ?></span><br>

    <input type="submit" value="Create Team">
</form>

</body>
</html>
