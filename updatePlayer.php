<?php

include 'config.php'; 

// get player data
if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    
    $sql = "SELECT * FROM Players WHERE player_id = '$player_id'";
    $result = mysqli_query($link, $sql);
    $player = mysqli_fetch_assoc($result);
} else {
    echo "No player ID provided!";
    exit;
}

// update player information
if (isset($_POST['update'])) {
    $fname = mysqli_real_escape_string($link, $_POST['fname']);
    $lname = mysqli_real_escape_string($link, $_POST['lname']);
    $position = mysqli_real_escape_string($link, $_POST['position']);
    $team_id = mysqli_real_escape_string($link, $_POST['team_id']);
    $height = mysqli_real_escape_string($link, $_POST['height']);
    $weight = mysqli_real_escape_string($link, $_POST['weight']);
    $age = mysqli_real_escape_string($link, $_POST['age']);
    $salary = mysqli_real_escape_string($link, $_POST['salary']);

    $update_sql = "UPDATE Players SET fname = '$fname', lname = '$lname', position = '$position', 
                  team_id = '$team_id', height = '$height', weight = '$weight', age = '$age', 
                  salary = '$salary' WHERE player_id = '$player_id'";

    if (mysqli_query($link, $update_sql)) {
        echo "Player updated successfully!";
        header("Location: index.php"); 
        exit;
    } else {
        echo "Error updating player: " . mysqli_error($link);
    }
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
    <header>
        <a href="index.php"><button>Home</button></a>
        <h1>Update Player</h1>
    </header>

    <main>
        <form method="POST">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $player['fname']; ?>" required><br>

            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $player['lname']; ?>" required><br>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" value="<?php echo $player['position']; ?>" required><br>

            <label for="team_id">Team ID:</label>
            <input type="number" id="team_id" name="team_id" value="<?php echo $player['team_id']; ?>"><br>

            <label for="height">Height (in):</label>
            <input type="number" id="height" name="height" value="<?php echo $player['height']; ?>"><br>

            <label for="weight">Weight (lb):</label>
            <input type="number" id="weight" name="weight" value="<?php echo $player['weight']; ?>"><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $player['age']; ?>"><br>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" value="<?php echo $player['salary']; ?>"><br>

            <button type="submit" name="update">Update Player</button>
        </form>
    </main>
</body>
</html>
