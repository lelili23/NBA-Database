<?php

include 'config.php'; 

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    $sql = "DELETE FROM Games WHERE game_id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $game_id); 

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: Could not delete the game.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Could not prepare the query.";
    }
} else {
    echo "Error: Game ID is missing.";
}

mysqli_close($link);
?>
