<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Messages;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $read = $_POST['read'] ?? null;

    if ($id !== null && $read !== null) {
        $message = Messages::find($id);
        if ($message && $message->recipient_id == $_SESSION['user_id']) {
            $message->is_read = $read ? 1 : 0;
            $message->save();
            echo 'success';
            exit;
        }
    }
}
echo 'error';
