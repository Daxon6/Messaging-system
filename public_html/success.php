<?php
session_start();
header('Refresh: 4; URL=index.php');
$message = $_SESSION['success_message'] ?? 'Operation sucessful!';
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div>
    <p><?php echo htmlspecialchars($message)?></p>
    <div>
        <p>You will be redirected to the home page shortly...</p>
    </div>
</div>
</body>
</html>
