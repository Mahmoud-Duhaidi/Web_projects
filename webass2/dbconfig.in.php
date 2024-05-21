<?php
$host = 'root';
$dbName = 'web1200340_db';
$username = 'web1200340_dbuser';
$password = '6C!DU36uu!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
