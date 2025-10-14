<?php
require __DIR__ . '/logic/registrationLogic.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Registration</h2>
<div>
    <form action="logic/registrationLogic.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" placeholder="Email" required>
        <span class="error"><?php echo $errors['email'] ?? ''; ?></span><br><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password" required><br><br>

        <label>Repeat password:</label>
        <input type="password" name="repeat_password" placeholder="Repeat password" required>
        <span class="error"><?php echo $errors['password'] ?? ''; ?></span><br><br>

        <label>Full name:</label>
        <input type="text" name="name" placeholder="Full name" required><br><br>

        <label>Phone:</label>
        <input type="text" name="phone" placeholder="Phone" required><br><br>

        <label id="PictureLabel">Picture:</label>
        <input type="file" name="picture" id="picture" class="custom-file-input"><br><br>

        <button type="submit" id="register">Register</button>
    </form>
</div>

<p><a href="login.php">Login</a></p>
<p><a href="password.php">Change password</a></p>
<p><a href="index.php">Home page</a></p>
</body>
</html>