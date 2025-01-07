<?php

include 'config.php'; 

// SQL query to get teams salary sums and most paid players
$query = "
    SELECT 
        t.name AS team_name,
        SUM(p.salary) AS total_salary,
        p.fname AS player_fname,
        p.lname AS player_lname,
        p.salary AS player_salary,
        p.position AS player_position
    FROM 
        Teams t
    JOIN 
        Players p ON t.team_id = p.team_id
    GROUP BY 
        t.team_id
    HAVING 
        p.salary = (SELECT MAX(p2.salary)
                    FROM Players p2
                    WHERE p2.team_id = t.team_id)
    ORDER BY 
        total_salary DESC;
";

$result = mysqli_query($link, $query);
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
        <h1>Team Salaries and Most Paid Players</h1>
        <p>This shows the sum of salaries for each team and the highest paid player on the team.</p>
    </header>

    <main>
        <?php
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table class='team-salaries-table'>";
                echo "<thead><tr><th>Team Name</th><th>Total Salary</th><th>Most Paid Player</th><th>Salary</th><th>Position</th></tr></thead><tbody>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
                    echo "<td>" . number_format($row['total_salary'], 0) . "</td>";
                    echo "<td>" . htmlspecialchars($row['player_fname'] . ' ' . $row['player_lname']) . "</td>";
                    echo "<td>" . number_format($row['player_salary'], 0) . "</td>";
                    echo "<td>" . htmlspecialchars($row['player_position']) . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody></table>";
            } else {
                echo "No results found.";
            }
        } else {
            echo "Error: Could not execute query.";
        }

        mysqli_close($link);
        ?>
    </main>
</body>
</html>
