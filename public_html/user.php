<?php

use App\Models\User;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../vendor/autoload.php';

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$user = User::where('id', $userId)->first();

$_SESSION['token'] = rand(1, 300000);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="user-container">
    <div class="user-text">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    </div>
    <?php if ($user->slika !== null): ?>
        <img src="slike/<?= $user->slika ?>" alt="<?= $user->username?>" class="slika">
    <?php endif ?>
</div>

<form action="logic/userLogic.php" method="POST" enctype="multipart/form-data" id="formaKorisnik">
    <div class="pictureAdd">
    <label id="PictureLabel">Picture:</label>
    <input type="file" name="slika" id="slika"> <br>
    </div>
    <button type="submit" class="pictureButtonSet">Set picture</button>
</form>
<?php if ($user->slika !== null): ?>
    <p>
    <form action="logic/deletePicture.php" method="POST">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <button type="submit" class="pictureButtonDelete">Delete picture</button>
    </form>
    </p>
<?php endif ?>
<?php
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
elseif (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
?>
<p><a href="logout.php">Logout</a></p>
<p><a href="messages.php">Poruke</a></p>
</body>
</html>