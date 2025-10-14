<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Login</h2>
<div>
    <form action="logic/loginLogic.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" placeholder="Email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <button type="submit" id="login">Login</button>
    </form>
</div>

<p><a href="registration.php">Registration</a></p>
<p><a href="password.php">Change password</a></p>
<p><a href="index.php">Home page</a></p>
</body>
</html>
