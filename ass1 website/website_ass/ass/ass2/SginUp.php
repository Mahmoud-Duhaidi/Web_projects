
<!DOCTYPE html>
<html>
  <head>
    <title>Sign Up</title>
  </head>
  <body>
    <h2>Sign Up</h2>
    <form action="register.php" method="post">
      <fieldset>
      <label>Email:</label>
      <input type="email" name="email" required /> <br /><br />
      <label >UaerName:</label>
      <input type="text" name="username" required><br><br>
      <label>Password:</label>
      <input
        type="password"
        name="password"
        minlength="8"
        required
      /><br /><br />

      <input type="submit" value="Sign Up" />
    </fieldset>
    </form>
    <p><a href="login.html">Sign In</a></p>
  </body>
</html>
