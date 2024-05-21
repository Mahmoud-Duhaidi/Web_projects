<?php
session_start();

require 'db.php';

$users_id = $_SESSION['users_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teams_name = $_POST['teams_name'];
    $teams_skill_level = $_POST['teams_skill_level'];
    $teams_game_day = $_POST['teams_game_day'];

    // Set the initial number of players to 0
    $teams_num_player = 0;

    // Insert the new team into the database
    $stmt = $pdo->prepare("INSERT INTO teams (teams_name, teams_skill_level, teams_num_player, teams_game_day, users_id) VALUES (:teams_name, :teams_skill_level, :teams_num_player, :teams_game_day, :users_id)");
    $stmt->bindValue(':teams_name', $teams_name);
    $stmt->bindValue(':teams_skill_level', $teams_skill_level);
    $stmt->bindValue(':teams_num_player', $teams_num_player);
    $stmt->bindValue(':teams_game_day', $teams_game_day);
    $stmt->bindValue(':users_id', $users_id);
    $stmt->execute();

    // Redirect back to the dashboard page
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Team</title>
    <link rel="stylesheet"  href="main.css">
</head>
<body>
    <h1>New Team</h1><br>
    <span> <a href="dashboard.php">dashboard</a></span>
    <br></br>
    <table>
    <tbody>
      <form method="POST" action="create_new_team.php">
        <tr>
          <td><label>Team Name:</label></td>
          <td><input type="text" name="teams_name" required></td>
        </tr>
        <tr>
          <td><label>Skill Level (1-5):</label></td>
          <td><input type="number" name="teams_skill_level" required min="1" max="5"></td>
        </tr>
        <tr>
          <td><label>Game Day:</label></td>
          <td><input type="text" name="teams_game_day" required></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;"><input type="submit" value="Submit"></td>
        </tr>
      </form>
    </tbody>
  </table>
</body>
</html>
