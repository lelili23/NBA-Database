<?php

include 'config.php'; 
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
        <h1>NBA Database: Lilian Le and Thai Le</h1>
    </header>

    <main>
        <p>Our project is a comprehensive platform for users to manage and analyze NBA 
            statistics. The application will allow users such as analysts, fans, and 
            coaches to view, update, and manage player and team statistics. On this application
            you can create, retrieve, update, and delete data for players, teams, stats, and games. </p>
        <h2>Players</h2>
        <a href="createPlayer.php"><button>Create New Player</button></a>
        <form action="viewTeamSalaries.php" method="get" class="salary-form">
            <button type="submit">View Team/Player Salaries</button>
        </form>
        <table>
            <thead>
                <tr>
                <th>Player ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Team</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>Age</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM Players";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formatted_salary = "$" . number_format($row['salary']);
                            echo "<tr>";
                            echo "<td>" . $row['player_id'] . "</td>";
                            echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                            echo "<td>" . $row['position'] . "</td>";
                            echo "<td>" . ($row['team_id'] ? $row['team_id'] : 'N/A') . "</td>";
                            echo "<td>" . $row['height'] . "</td>";
                            echo "<td>" . $row['weight'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $formatted_salary . "</td>";
                            echo "<td>
                                <a href='viewPlayerStat.php?id=" . $row['player_id'] . "'>View Stats</a> |
                                <a href='updatePlayer.php?id=" . $row['player_id'] . "'>Update</a> |
                                <a href='deletePlayer.php?id=" . $row['player_id'] . "' onclick=\"return confirm('Are you sure you want to delete this player?')\">Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No players found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>


        <h2>Teams</h2>
        <a href="createTeam.php"><button>Create New Team</button></a>
        <table>
            <thead>
                <tr>
                    <th>Team ID</th>
                    <th>Team Name</th>
                    <th>Coach</th>
                    <th>Home City</th>
                    <th>Mascot</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql2 = "SELECT * FROM Teams";
                    $result2 = mysqli_query($link, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            echo "<tr>";
                            echo "<td>" . $row['team_id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['coach_fname'] . " " . $row['coach_lname'] . "</td>";
                            echo "<td>" . $row['home_city'] . "</td>";
                            echo "<td>" . $row['mascot'] . "</td>";
                            echo "<td>
                                <a href='viewTeamStat.php?id=" . $row['team_id'] . "'>View Stats</a> |
                                <a href='updateTeam.php?id=" . $row['team_id'] . "'>Update</a> |
                                <a href='deleteTeam.php?id=" . $row['team_id'] . "' onclick=\"return confirm('Are you sure you want to delete this team?')\">Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No teams found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>


        <h2>Games</h2>
        <a href="createGame.php"><button>Create New Game</button></a>
        <table>
            <thead>
                <tr>
                    <th>Game ID</th>
                    <th>Date</th>
                    <th>Final Score</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql3 = "SELECT g.game_id, g.date, g.final_score, t1.name AS home_team_name, t2.name AS away_team_name
                            FROM Games g
                            JOIN Plays_In p1 ON g.game_id = p1.game_id AND p1.role = 'home'
                            JOIN Plays_In p2 ON g.game_id = p2.game_id AND p2.role = 'away'
                            JOIN Teams t1 ON p1.team_id = t1.team_id
                            JOIN Teams t2 ON p2.team_id = t2.team_id";
                    $result3 = mysqli_query($link, $sql3);
                    if (mysqli_num_rows($result3) > 0) {
                        while ($row = mysqli_fetch_assoc($result3)) {
                            echo "<tr>";
                            echo "<td>" . $row['game_id'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['final_score'] . "</td>";
                            echo "<td>" . $row['home_team_name'] . "</td>";
                            echo "<td>" . $row['away_team_name'] . "</td>";
                            echo "<td>
                                <a href='deleteGame.php?id=" . $row['game_id'] . "' onclick=\"return confirm('Are you sure you want to delete this game?')\">Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No games found.</td></tr>";
                    }
                ?>
            </tbody>
        </table>

    </main>
</body>
</html>
