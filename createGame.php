<?php

include 'config.php'; 

$date = $final_score = $home_team = $away_team = "";
$date_err = $score_err = $home_team_err = $away_team_err = "";

// retrieve teams for dropdown
$teams = [];
$sql = "SELECT team_id, name FROM Teams";
$result = mysqli_query($link, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $teams[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate all inputs
    if (empty(trim($_POST["date"]))) {
        $date_err = "Please enter the game date.";
    } else {
        $date = mysqli_real_escape_string($link, $_POST["date"]);
    }

    if (empty(trim($_POST["final_score"]))) {
        $score_err = "Please enter the final score.";
    } else {
        $final_score = mysqli_real_escape_string($link, $_POST["final_score"]);
    }

    if (empty($_POST["home_team"])) {
        $home_team_err = "Please select the home team.";
    } else {
        $home_team = $_POST["home_team"];
    }

    if (empty($_POST["away_team"])) {
        $away_team_err = "Please select the away team.";
    } else {
        $away_team = $_POST["away_team"];
    }

    // Attempt to insert into database
    if (empty($date_err) && empty($score_err) && empty($home_team_err) && empty($away_team_err)) {
        $sql = "INSERT INTO Games (date, final_score) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $date, $final_score);

            if (mysqli_stmt_execute($stmt)) {
                $game_id = mysqli_insert_id($link);

                $sql2 = "INSERT INTO Plays_In (game_id, team_id, role) VALUES (?, ?, 'home'), (?, ?, 'away')";
                if ($stmt2 = mysqli_prepare($link, $sql2)) {
                    mysqli_stmt_bind_param($stmt2, "iiii", $game_id, $home_team, $game_id, $away_team);

                    if (mysqli_stmt_execute($stmt2)) {
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Error: Could not insert teams.";
                    }

                    mysqli_stmt_close($stmt2);
                }
            } else {
                echo "Error: Could not insert the game.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NBA Database</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <main>
        <a href="index.php"><button>Home</button></a>
        <h1>Create New Game</h1>
        <form action="createGame.php" method="post">
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo $date; ?>">
            <span><?php echo $date_err; ?></span>

            <label for="final_score">Final Score (XX-XX):</label>
            <input type="text" name="final_score" value="<?php echo $final_score; ?>">
            <span><?php echo $score_err; ?></span>

            <label for="home_team">Home Team:</label>
            <select name="home_team">
                <option value="">Select Home Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['team_id']; ?>" <?php echo $home_team == $team['team_id'] ? 'selected' : ''; ?>>
                        <?php echo $team['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span><?php echo $home_team_err; ?></span>

            <label style="margin-top: 20px" for="away_team">Away Team:</label>
            <select name="away_team">
                <option value="">Select Away Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['team_id']; ?>" <?php echo $away_team == $team['team_id'] ? 'selected' : ''; ?>>
                        <?php echo $team['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span><?php echo $away_team_err; ?></span>

            <input type="submit" value="Create Game">
        </form>
    </main>
</body>
</html>
