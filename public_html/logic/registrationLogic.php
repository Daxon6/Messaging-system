<?php

use App\Models\User;

require_once __DIR__ . '/../../vendor/autoload.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeat_password"];
    $username = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);

    if (User::where('email', $email)->exists()) {
        $errors['email'] = "An account with that email address is already registered.";
    }

    if ($password !== $repeatPassword) {
        $errors['password'] = "Passwords do not match.";
    }

    if (empty($errors)) {
        User::insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
        ]);

        session_start();
        $_SESSION['success_message'] = 'Registered successfully!';
        header('Location: ../success.php');
        exit();
    }
}