<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Change</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Password Change</h2>
<div>
    <form action="logic/passwordLogic.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" placeholder="Email" required><br><br>

        <label>Old password:</label>
        <input type="password" name="old_password" placeholder="Password" required><br><br>

        <label>New password:</label>
        <input type="password" name="new_password" placeholder="Password" required><br><br>

        <label>Repeat new password:</label>
        <input type="password" name="repeat_new_password" placeholder="Password" required><br><br>

        <button type="submit" id="register">Change Password</button>
    </form>
</div>

<p><a href="registration.php">Registration</a></p>
<p><a href="login.php">Login</a></p>
<p><a href="index.php">Home page</a></p>

<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>
</body>
</html>
