<?php

include 'config.php'; 

// get player stats data
if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    $check_stats_sql = "SELECT * FROM Player_Statistics WHERE player_id = '$player_id'";
    $check_stats_result = mysqli_query($link, $check_stats_sql);

    // if no stats exist, create default
    if (mysqli_num_rows($check_stats_result) == 0) {
        $insert_default_stats_sql = "INSERT INTO Player_Statistics (player_id, ppg, apg, rpg, spg, bpg, turnovers, fg_percentage, tp_percentage, ft_percentage)
                                     VALUES ('$player_id', 0, 0, 0, 0, 0, 0, 0, 0, 0)";
        if (mysqli_query($link, $insert_default_stats_sql)) {
            echo "Player stats created with default values.";
        } else {
            echo "Error creating player stats: " . mysqli_error($link);
        }
    }

    $stats_sql = "SELECT * FROM Player_Statistics WHERE player_id = '$player_id'";
    $stats_result = mysqli_query($link, $stats_sql);
    $stats = mysqli_fetch_assoc($stats_result);

    $player_sql = "SELECT * FROM Players WHERE player_id = '$player_id'";
    $player_result = mysqli_query($link, $player_sql);
    $player = mysqli_fetch_assoc($player_result);
} else {
    echo "No player ID provided!";
    exit;
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
        <h1>Player Stats for <?php echo $player['fname'] . ' ' . $player['lname']; ?></h1>
    </header>

    <main>
        <h2>Player Info</h2>
        <table class="horizontal-table">
            <tr>
                <th>Name</th>
                <td><?php echo $player['fname'] . ' ' . $player['lname']; ?></td>
            </tr>
            <tr>
                <th>Position</th>
                <td><?php echo $player['position']; ?></td>
            </tr>
            <tr>
                <th>Height</th>
                <td><?php echo $player['height']; ?> cm</td>
            </tr>
            <tr>
                <th>Weight</th>
                <td><?php echo $player['weight']; ?> kg</td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo $player['age']; ?></td>
            </tr>
            <tr>
                <th>Salary</th>
                <td>$<?php echo number_format($player['salary'], 2); ?></td>
            </tr>
        </table>

        <h2>Player Stats</h2>
        <table class="horizontal-table">
            <tr>
                <th>Points Per Game (PPG)</th>
                <td><?php echo $stats['ppg']; ?></td>
            </tr>
            <tr>
                <th>Assists Per Game (APG)</th>
                <td><?php echo $stats['apg']; ?></td>
            </tr>
            <tr>
                <th>Rebounds Per Game (RPG)</th>
                <td><?php echo $stats['rpg']; ?></td>
            </tr>
            <tr>
                <th>Steals Per Game (SPG)</th>
                <td><?php echo $stats['spg']; ?></td>
            </tr>
            <tr>
                <th>Blocks Per Game (BPG)</th>
                <td><?php echo $stats['bpg']; ?></td>
            </tr>
            <tr>
                <th>Turnovers Per Game</th>
                <td><?php echo $stats['turnovers']; ?></td>
            </tr>
            <tr>
                <th>Field Goal Percentage (FG%)</th>
                <td><?php echo $stats['fg_percentage']; ?>%</td>
            </tr>
            <tr>
                <th>Three-Point Percentage (3P%)</th>
                <td><?php echo $stats['tp_percentage']; ?>%</td>
            </tr>
            <tr>
                <th>Free Throw Percentage (FT%)</th>
                <td><?php echo $stats['ft_percentage']; ?>%</td>
            </tr>
        </table>

        <a href="updatePlayerStats.php?id=<?php echo $player['player_id']; ?>"><button>Update Stats</button></a>
    </main>
</body>
</html>
