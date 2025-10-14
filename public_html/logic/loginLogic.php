<?php

use App\Models\User;

require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $user = User::where('email', $email)->first();

    if ($user && password_verify($password, $user->password)) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;

        header('Location: ../user.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: ../login.php');
        exit();
    }
}
?>
