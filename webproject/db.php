<?php
$host = 'localhost';
$dbName = 'football_team';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
