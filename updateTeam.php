<?php

include 'config.php'; 

// get team data
if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    $sql = "SELECT * FROM Teams WHERE team_id = '$team_id'";
    $result = mysqli_query($link, $sql);
    $team = mysqli_fetch_assoc($result);
} else {
    echo "No team ID provided!";
    exit;
}

// update team data
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $coach_fname = mysqli_real_escape_string($link, $_POST['coach_fname']);
    $coach_lname = mysqli_real_escape_string($link, $_POST['coach_lname']);
    $home_city = mysqli_real_escape_string($link, $_POST['home_city']);
    $mascot = mysqli_real_escape_string($link, $_POST['mascot']);

    $update_sql = "UPDATE Teams SET name = '$name', coach_fname = '$coach_fname', coach_lname = '$coach_lname', 
                  home_city = '$home_city', mascot = '$mascot' WHERE team_id = '$team_id'";

    if (mysqli_query($link, $update_sql)) {
        echo "Team updated successfully!";
        header("Location: index.php"); 
        exit;
    } else {
        echo "Error updating team: " . mysqli_error($link);
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
        <h1>Update Team</h1>
    </header>

    <main>
        <form method="POST">
            <label for="name">Team Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $team['name']; ?>" required><br>

            <label for="coach_fname">Coach First Name:</label>
            <input type="text" id="coach_fname" name="coach_fname" value="<?php echo $team['coach_fname']; ?>" required><br>

            <label for="coach_lname">Coach Last Name:</label>
            <input type="text" id="coach_lname" name="coach_lname" value="<?php echo $team['coach_lname']; ?>" required><br>

            <label for="home_city">Home City:</label>
            <input type="text" id="home_city" name="home_city" value="<?php echo $team['home_city']; ?>"><br>

            <label for="mascot">Mascot:</label>
            <input type="text" id="mascot" name="mascot" value="<?php echo $team['mascot']; ?>"><br>

            <button type="submit" name="update">Update Team</button>
        </form>
    </main>
</body>
</html>
