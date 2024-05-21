<?php

session_start();

if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$users_id = $_SESSION['users_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teams_id = $_POST['teams_id'];
    $players_name = $_POST['players_name'];

    // Insert the new player into the player table
    $stmt = $pdo->prepare("INSERT INTO players (players_name, teams_id) VALUES (:players_name, :teams_id)");
    $stmt->bindValue(':players_name', $players_name);
    $stmt->bindValue(':teams_id', $teams_id);
    $stmt->execute();

    // Update the number of players in the team table
    $stmt = $pdo->prepare("UPDATE teams SET teams_num_player = teams_num_player + 1 WHERE teams_id = :teams_id");
    $stmt->bindValue(':teams_id', $teams_id);
    $stmt->execute();

    // Redirect back to the team details page
    header("Location: team_details.php?teams_id=$teams_id");
    exit();
}
?>
