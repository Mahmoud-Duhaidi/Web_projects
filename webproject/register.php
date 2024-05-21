<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users_name = $_POST['users_name'];
    $users_email = $_POST['users_email'];
    $users_password = $_POST['users_password'];
    $users_confirmPW = $_POST['users_confirmPW'];

    if ($users_password !== $users_confirmPW) {
        echo 'Passwords do not match !!!, Please try again.';
    }
     else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE users_email = :users_email");
        $stmt->bindValue(':users_email', $users_email);
        $stmt->execute();
        $existEmail = $stmt->fetch();

        if ($existEmail) {
            echo 'Email already exists !!!, Can you Please choose a different email.';
        }
         else {
            $stmt = $pdo->prepare("INSERT INTO users (users_name, users_email, users_password) VALUES (:users_name, :users_email, :users_password)");
            $stmt->bindValue(':users_name', $users_name);
            $stmt->bindValue(':users_email', $users_email);
            $stmt->bindValue(':users_password', $users_password);
            $stmt->execute();

            echo 'Register account successful! You can now log in.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Page</title>
    <link rel="stylesheet"  href="main.css">
</head>
<body>
    <center>
        <h2>Welcome!</h2>
        <br><br>
        
        <table>
  <thead>
    <tr>
      <th colspan="2">Register</th>
    </tr>
  </thead>
  <tbody>
    <form method="post" action="register.php">
      <tr>
        <td><label>User Name:</label></td>
        <td><input type="text" name="users_name" required></td>
      </tr>
      <tr>
        <td><label>Email:</label></td>
        <td><input type="email" name="users_email" required></td>
      </tr>
      <tr>
        <td><label>Password:</label></td>
        <td><input type="password" name="users_password" required></td>
      </tr>
      <tr>
        <td><label>Confirm Password:</label></td>
        <td><input type="password" name="users_confirmPW" required></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Register"></td>
      </tr>
      </form>
      <tr>
        <td colspan="2">
          <p>  <a href="login.php">lest go and open your profile</a></p>
        </td>
      </tr>
    </tbody>
</table>
    </center>
</body>
</html>
