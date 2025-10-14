<?php

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Messages;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id !== null) {
        $message = Messages::find($id);
        if ($message && $message->sender_id == $_SESSION['user_id']) {
            $message->destroy();
            echo 'success';
            exit;
        }
    }
}
echo 'error';
