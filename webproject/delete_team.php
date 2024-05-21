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
        $stmt = $pdo->prepare("SELECT * FROM teams WHERE teams_id = :team_id AND users_id = :user_id");
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

        // Delete the team from the database
        $stmt = $pdo->prepare("DELETE FROM teams WHERE teams_id = :team_id AND users_id = :user_id");
        $stmt->bindValue(':team_id', $team_id);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();

        // Redirect to the dashboard
        header('Location: dashboard.php');
        exit();
    }
}
?>