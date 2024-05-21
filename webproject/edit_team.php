<?php
session_start();

if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$user_id = $_SESSION['users_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['teams_id'])) {
        $team_id = $_GET['teams_id'];

        // Retrieve team details
        $stmt = $pdo->prepare("SELECT * FROM teams WHERE teams_id = :team_id AND users_id = :users_id");
        $stmt->bindValue(':team_id', $team_id);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $team = $stmt->fetch();

        // Check if the team exists and belongs to the user
        if (!$team) {
            // Redirect to the dashboard if the team doesn't exist or doesn't belong to the user
            header('Location: dashboard.php');
            exit();
        }
    } 
}



    // Update the team information in the database
    $stmt = $pdo->prepare("UPDATE teams SET teams_name = :team_name, teams_skill_level = :team_skill_level, teams_game_day = :team_game_day WHERE teams_id = :team_id AND users_id = :users_id");
    $stmt->bindValue(':team_name', $team_name);
    $stmt->bindValue(':team_skill_level', $team_skill_level);
    $stmt->bindValue(':team_game_day', $team_game_day);
    $stmt->bindValue(':team_id', $team_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    // Redirect back to the team details page
    header("Location: team_details.php?team_id=$team_id");
    exit();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Team</title>
    <link rel="stylesheet"  href="main.css">
</head>
<body>
    <h1>Edit Team</h1>
    <a href="dashboard.php">Dashboard</a>
    <br><br>
    <form method="POST" action="">
        <input type="hidden" name="team_id" value="<?php echo $team['teams_id']; ?>">
        <label>Team Name:</label>
        <input type="text" name="teams_name" value="<?php echo $team['teams_name']; ?>" required>
        <br><br>
        <label>Skill Level (1-5):</label>
        <input type="number" name="teams_skill_level" value="<?php echo $team['teams_skill_level']; ?>" required min="1" max="5">
        <br><br>
        <label>Game Day:</label>
        <input type="text" name="teams_game_day" value="<?php echo $team['teams_game_day']; ?>" required>
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <br><br>
    <p><a href="delete_team.php?team_id=<?php echo $team['teams_id']; ?>">Delete Team</a></p>
</body>
</html>