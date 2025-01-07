<?php

include 'config.php';

if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    $delete_team_stats_sql = "DELETE FROM Team_Statistics WHERE team_id = '$team_id'";
    mysqli_query($link, $delete_team_stats_sql);

    $delete_team_sql = "DELETE FROM Teams WHERE team_id = '$team_id'";

    if (mysqli_query($link, $delete_team_sql)) {
        echo "Team deleted successfully. <a href='index.php'>Go back to home page</a>";
    } else {
        echo "Error deleting team: " . mysqli_error($link);
    }
} else {
    echo "No team ID provided!";
    exit;
}
?>
