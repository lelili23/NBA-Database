<?php

include 'config.php'; 

// get team stats
if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    $stats_sql = "SELECT * FROM Team_Statistics WHERE team_id = '$team_id'";
    $stats_result = mysqli_query($link, $stats_sql);
    $stats = mysqli_fetch_assoc($stats_result);

    $team_sql = "SELECT * FROM Teams WHERE team_id = '$team_id'";
    $team_result = mysqli_query($link, $team_sql);
    $team = mysqli_fetch_assoc($team_result);
} else {
    echo "No team ID provided!";
    exit;
}

// update team stats
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ppg = $_POST['ppg'];
    $apg = $_POST['apg'];
    $rpg = $_POST['rpg'];
    $spg = $_POST['spg'];
    $bpg = $_POST['bpg'];
    $turnovers = $_POST['turnovers'];
    $fg_percentage = $_POST['fg_percentage'];
    $tp_percentage = $_POST['tp_percentage'];
    $ft_percentage = $_POST['ft_percentage'];

    $update_sql = "UPDATE Team_Statistics SET 
                    ppg = '$ppg', apg = '$apg', rpg = '$rpg', spg = '$spg', 
                    bpg = '$bpg', turnovers = '$turnovers', fg_percentage = '$fg_percentage', 
                    tp_percentage = '$tp_percentage', ft_percentage = '$ft_percentage'
                    WHERE team_id = '$team_id'";

    if (mysqli_query($link, $update_sql)) {
        echo "Stats updated successfully!";
        header("Location: viewTeamStat.php?id=$team_id"); 
        exit;
    } else {
        echo "Error updating stats: " . mysqli_error($link);
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
        <h1>Update Team Stats</h1>
    </header>

    <main>
        <h2>Update Stats for Team: <?php echo $team['name']; ?></h2>

        <form action="updateTeamStats.php?id=<?php echo $team_id; ?>" method="post">
            <label for="ppg">Points Per Game (PPG):</label>
            <input type="text" id="ppg" name="ppg" value="<?php echo $stats['ppg']; ?>" required><br>

            <label for="apg">Assists Per Game (APG):</label>
            <input type="text" id="apg" name="apg" value="<?php echo $stats['apg']; ?>" required><br>

            <label for="rpg">Rebounds Per Game (RPG):</label>
            <input type="text" id="rpg" name="rpg" value="<?php echo $stats['rpg']; ?>" required><br>

            <label for="spg">Steals Per Game (SPG):</label>
            <input type="text" id="spg" name="spg" value="<?php echo $stats['spg']; ?>" required><br>

            <label for="bpg">Blocks Per Game (BPG):</label>
            <input type="text" id="bpg" name="bpg" value="<?php echo $stats['bpg']; ?>" required><br>

            <label for="turnovers">Turnovers Per Game:</label>
            <input type="text" id="turnovers" name="turnovers" value="<?php echo $stats['turnovers']; ?>" required><br>

            <label for="fg_percentage">Field Goal Percentage (FG%):</label>
            <input type="text" id="fg_percentage" name="fg_percentage" value="<?php echo $stats['fg_percentage']; ?>" required><br>

            <label for="tp_percentage">Three-Point Percentage (3P%):</label>
            <input type="text" id="tp_percentage" name="tp_percentage" value="<?php echo $stats['tp_percentage']; ?>" required><br>

            <label for="ft_percentage">Free Throw Percentage (FT%):</label>
            <input type="text" id="ft_percentage" name="ft_percentage" value="<?php echo $stats['ft_percentage']; ?>" required><br>

            <button type="submit">Update Stats</button>
        </form>
    </main>
</body>
</html>
