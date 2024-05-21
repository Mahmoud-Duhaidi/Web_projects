<?php
session_start();

if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$users_id = $_SESSION['users_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE users_id = :users_id");
$stmt->bindValue(':users_id', $users_id);
$stmt->execute();
$users = $stmt->fetch();


$users_name = $users['users_name'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet"  href="main.css">
</head>
<body>
    <h1>Welcome <?php echo $users_name; ?></h1><br><br>
    <span> <a href="logout.php">log out</a> </span>  
    
    <br></br>
    <table>
    <thead>
      <tr>
        <th>Team Name</th>
        <th>Skill Level (1-5)</th>
        <th>Players</th>
        <th>Game Day</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmt = $pdo->query("SELECT * FROM teams");
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($teams as $team) {
          echo "<tr>";
          echo "<td><a href='team_details.php?teams_id={$team['teams_id']}'>{$team['teams_name']}</a></td>";
          echo "<td>{$team['teams_skill_level']}</td>";
          echo "<td>{$team['teams_num_player']}/9</td>";
          echo "<td>{$team['teams_game_day']}</td>";
          echo "</tr>";
        }
      ?>
      <tr>
        <td colspan="4" style="text-align: center;">
          <button onclick="location.href='create_new_team.php'">Create New Team</button>
        </td>
      </tr>
    </tbody>
  </table>

    <br></br>
    <br></br>

    
    <br></br>
          
    
</body>
</html>
