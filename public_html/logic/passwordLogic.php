<?php

use App\Models\User;

require_once __DIR__ . '/../../vendor/autoload.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $repeatNewPassword = $_POST['repeat_new_password'];

    $user = User::where('email', $email)->first();

    if ($user && password_verify($oldPassword, $user->password)) {
        if ($newPassword == $repeatNewPassword) {
            $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
            $user->save();

            session_start();
            $_SESSION['success_message'] = 'Password changed successfully!';
            header('Location: ../success.php');
            exit();

        } else {
            $error = 'Passwords do not match';
        }
    } else {
        $error = 'Incorrect email or password';
    }
}
?>