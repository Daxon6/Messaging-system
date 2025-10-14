<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;
use App\Models\Messages;

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$title = $_POST['title'];
$body = $_POST['body'];
$recipientId = $_POST['recipient_id'];
$urgency = $_POST['urgency'];

$sender = User::where('id', $_SESSION['user_id'])->first();
$recipient = User::where('id', $recipientId)->first();

Messages::insert([
    'sender_id' => $sender->id,
    'recipient_id' => $recipient->id,
    'title' => $title,
    'body' => $body,
    'urgency' => $urgency,
    'sent_at' => (new DateTime('now', new DateTimeZone('Europe/Belgrade')))->format('Y-m-d H:i:s'),
    'is_read' => 0,
]);

$_SESSION['mail'] = [
    'from_email' => $sender->email,
    'from_name' => $sender->username,
    'to_email' => $recipient->email,
    'to_name' => $recipient->username,
    'subject' => $urgency === 'urgent' ? '[URGENT] ' . $title : $title,
    'body' => nl2br(htmlspecialchars($body))
];

header('Location: sendMailLogic.php');
exit();
