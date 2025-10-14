<?php

use App\Models\User;
use Vista\Upload\FileUploader;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_SESSION['token']) || !isset($_POST['token'])
    || (int) $_POST['token'] !== (int) $_SESSION['token']) {

    header('Location: ../user.php');
    exit();
}

require_once __DIR__ . "/../../vendor/autoload.php";

$user_id = $_SESSION['user_id'];
$user = User::where('id', $user_id)->first();

if ($user->slika == null) {
    header('Location: ../user.php');
    exit();
}

$putanja = __DIR__ . '/../pictures/' . $user->slika;

$uploader = new FileUploader('');
$uploader->delete($putanja);

$user->slika = null;
$user->save();
header('Location: ../user.php');