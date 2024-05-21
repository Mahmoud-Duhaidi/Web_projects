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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['teams_id'])) {
        $teams_id = $_GET['teams_id'];

        // Retrieve team details
        $stmt = $pdo->prepare("SELECT * FROM teams WHERE teams_id = :teams_id");
        $stmt->bindValue(':teams_id', $teams_id);
        $stmt->execute();
        $teams = $stmt->fetch();

        // Retrieve players in the team
        $stmt = $pdo->prepare("SELECT * FROM players WHERE teams_id = :teams_id");
        $stmt->bindValue(':teams_id', $teams_id);
        $stmt->execute();
        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the team is full (more than or equal to 9 players)
        $teams_num_players = count($players);
        $team_full = ($teams_num_players >= 9);
    } else {
        // Redirect back to the dashboard if team_id is not specified
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Details</title>
    <link rel="stylesheet"  href="main.css">
</head>
<body>
    <h1><?php echo $teams['teams_name']; ?></h1> <br>
    <span> <a href="dashboard.php">Dashboard</a> </span>
    
    <br><br>
    
    <p>Team Name: <?php echo $teams['teams_name']; ?></p>
    <p>Skill Level: <?php echo $teams['teams_skill_level']; ?></p>
    <p>Game Day: <?php echo $teams['teams_game_day']; ?></p>

    <h3>Players:</h3>
    
    <?php foreach ($players as $player): ?>
      
        <h5> <?php echo $player['players_name']; ?> </h5>
      
    <?php endforeach; ?>
   

    <?php if ($teams['users_id'] == $users_id): ?>
        <?php if (!$team_full && $teams_num_players < 9): ?>
            <!-- Add player form -->
            <h3>Add Player:</h3>
            <table>
    <tbody>
      <form method="POST" action="add_player.php">
      
          <input type="hidden" name="teams_id" value="<?php echo $teams['teams_id']; ?>">
        
        <tr>
          <td><label>Player Name:</label></td>
          <td><input type="text" name="players_name" required></td>
        </tr>
        <tr>
          <td colspan="2" ><input type="submit" value="Add"></td>
        </tr>
      </form>
    </tbody>
  </table>
        <?php else: ?>
            <h4>The team is full, you cannot add more.</h4>
        <?php endif; ?>

        <!-- Option to edit or delete the team -->
        <br>
        <span><a href="edit_team.php?teams_id=<?php echo $teams['teams_id']; ?>">Edit Team</a></span><br><br>
        <span><a href="delete_team.php?teams_id=<?php echo $teams['teams_id']; ?>">Delete Team</a></span><br><br>
        
        <?php endif; ?>
</body>
</html>
