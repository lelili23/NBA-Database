<?php

include 'config.php'; 

// get team stats
if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    $check_stats_sql = "SELECT * FROM Team_Statistics WHERE team_id = '$team_id'";
    $check_stats_result = mysqli_query($link, $check_stats_sql);

    // if no stats exist, create default
    if (mysqli_num_rows($check_stats_result) == 0) {
        $insert_default_stats_sql = "INSERT INTO Team_Statistics (team_id, ppg, apg, rpg, spg, bpg, turnovers, fg_percentage, tp_percentage, ft_percentage)
                                     VALUES ('$team_id', 0, 0, 0, 0, 0, 0, 0, 0, 0)";
        if (mysqli_query($link, $insert_default_stats_sql)) {
            echo "Team stats created with default values.";
        } else {
            echo "Error creating team stats: " . mysqli_error($link);
        }
    }

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
        <h1>Team Stats for <?php echo $team['name']; ?></h1>
    </header>

    <main>
        <h2>Team Info</h2>
        <table class="horizontal-table">
            <tr>
                <th><strong>Team ID</strong></th>
                    <td><?php echo $team['team_id']; ?></td>
                </tr>
                <tr>
                    <th><strong>Team Name</strong></th>
                    <td><?php echo $team['name']; ?></td>
                </tr>
                <tr>
                    <th><strong>Coach</strong></th>
                    <td><?php echo $team['coach_fname'] . " " . $team['coach_lname']; ?></td>
                </tr>
                <tr>
                    <th><strong>Home City</strong></th>
                    <td><?php echo $team['home_city']; ?></td>
                </tr>
                <tr>
                    <th><strong>Mascot</strong></th>
                    <td><?php echo $team['mascot']; ?></td>
                </tr>
        </table>

        <h2>Team Stats</h2>
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

        <a href="updateTeamStats.php?id=<?php echo $team['team_id']; ?>"><button>Update Stats</button></a>
    </main>
</body>
</html>
