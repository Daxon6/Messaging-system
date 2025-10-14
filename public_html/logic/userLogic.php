<?php

use App\Models\User;
use Vista\Upload\FileUploader;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$userId = $_SESSION['user_id'];

require_once __DIR__ . '/../../vendor/autoload.php';

$uploader = new FileUploader('slika');

$imeFajla = hash('sha512', $userId);
$ekstenzija = '.' . $uploader->getOriginalExtension();

$provera = $uploader->setAllowedMimeTypes(['image/png', 'image/jpeg', 'image/gif'])
    ->setMaxFileSize(1024 * 1024 * 2)
    ->setUploadDir(__DIR__ . '/../pictures')
    ->setFilename($imeFajla)
    ->setFilenameSuffix($ekstenzija)
    ->upload();

if (!$provera) {
    $_SESSION['error'] = $uploader->getErrors()[0];
    header('Location: ../user.php');
    exit();
}

$user = User::where('id', $userId)->first();

$user->slika = $imeFajla . $ekstenzija;
$user->save();

$_SESSION['success'] = 'Picture successfully set!';
header('Location: ../user.php');
exit();