<?php

include 'config.php';

if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    $delete_stats_sql = "DELETE FROM Player_Statistics WHERE player_id = '$player_id'";
    mysqli_query($link, $delete_stats_sql);

    $delete_player_sql = "DELETE FROM Players WHERE player_id = '$player_id'";

    if (mysqli_query($link, $delete_player_sql)) {
        echo "Player deleted successfully. <a href='index.php'>Go back to home page</a>";
    } else {
        echo "Error deleting player: " . mysqli_error($link);
    }
} else {
    echo "No player ID provided!";
    exit;
}
?>
