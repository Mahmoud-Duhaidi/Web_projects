<?php
session_start();

require 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users_email = $_POST['users_email'];
    $users_password = $_POST['users_password'];

  
    $stmt = $pdo->prepare("SELECT * FROM users WHERE users_email = :users_email AND users_password = :users_password");
    $stmt->bindValue(':users_email', $users_email);
    $stmt->bindValue(':users_password', $users_password);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['users_id'] = $user['users_id'];
        header('Location: dashboard.php');
        exit();
    } else { 
        echo 'Invalid email or password.';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Kickball League</title>
        <link rel="stylesheet"  href="main.css">
    </head>
    <body>
        <center>
        <br><br>
        <h2>Welcome!</h2><br><br>
        <table>
    <thead>
      <tr>
        <th colspan="2">Log In</th>
      </tr>
    </thead>
    <tbody>
      <form method="POST" action="login.php">
        <tr>
          <td><label>Email:</label></td>
          <td><input type="email" name="users_email" placeholder="Email" required></td>
        </tr>
        <tr>
          <td><label>Password:</label></td>
          <td><input type="password" name="users_password" placeholder="Password" required></td>
        </tr>
        <tr>
          <td colspan="2" ><input type="submit" value="Login" style="padding: 10px 300px;"></td>
        </tr>
      </form>
      <tr>
        <td colspan="2">
          <p>Don't have an account yet? <a href="register.php">Register</a></p>
        </td>
      </tr>
    </tbody>
  </table>
</body>

            <br>
        </center>
    </body>
</html>
