<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\User;
use App\Models\Messages;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$users = User::where('id', '!=', $_SESSION['user_id'])->get();

$myId = $_SESSION['user_id'];

$messages = Messages::where('sender_id', $myId)
    ->orwhere('recipient_id', $myId)
    ->orderBy('id', 'desc')
    ->get();

//$sentMessages = Messages::where('sender_id', $myId)->get();
//$receivedMessages = Messages::where('recipient_id', $myId)->get();
//
//$messages = array_merge($sentMessages->toArray(), $receivedMessages->toArray());
//
//usort($messages, function ($a, $b) {
//    $timeA = $a->sent_at ? strtotime($a->sent_at) : 0;
//    $timeB = $b->sent_at ? strtotime($b->sent_at) : 0;
//    return $timeB - $timeA;
//});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Message</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<p><a href="user.php">Profile</a></p>
<div class="container">
    <h2>Send a Message</h2>
    <form action="logic/messagesLogic.php" method="POST"">

    <input type="text" name="title" placeholder="Title" required>

    <textarea name="body" placeholder="Message Body" maxlength="160" required></textarea>

    <select name="recipient_id" required>
        <option value="">-- Select a User --</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->id ?>">
                <?= htmlspecialchars($user->username) ?> (<?= htmlspecialchars($user->email) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <div>
        <label><input type="radio" name="urgency" value="urgent" required> Urgent</label>
        <label><input type="radio" name="urgency" value="normal" required> Not Urgent</label>
    </div>

    <button type="submit" id="register">Send Message</button>
    </form>
</div>
    <h3>Your Messages</h3>
    <div class="messages-list">
        <?php foreach ($messages as $msg):
            $isSent = $msg->sender_id == $myId;
            $otherUser = User::where('id', $isSent ? $msg->recipient_id : $msg->sender_id)->first();
            $urgencyClass = $msg->urgency === 'urgent' ? 'urgent' : 'normal';
            ?>
            <div class="message <?= $urgencyClass ?>" data-message-id="<?= $msg->id ?>">
                <p class="message-header">
                    <img src="slike/<?= htmlspecialchars($otherUser->slika) ?>" alt="<?= htmlspecialchars($otherUser->username) ?>" class="avatar">
                <p><?= $isSent ? 'Sent!' : 'Received!' ?></p>
                <div class="message-meta">
                    <strong>
                        <?= $isSent ? 'To:' : 'From:' ?>
                        <?= htmlspecialchars($otherUser->username) ?>
                    </strong>
                    <span class="title">Title: <?= htmlspecialchars($msg->title) ?></span>
                    <small class="time">
                        Date:
                        <?= $msg->sent_at ? date('d.m.Y H:i', strtotime($msg->sent_at) + 2 * 3600) : 'Unknown time' ?>
                    </small>
                </div>
                </p>
                <div class="message-body">
                    <?= nl2br(htmlspecialchars($msg->body)) ?>
                </div>
                <p class="message-actions">
                    <?php if (!$isSent): ?>
                        <button class="toggle-read-btn"
                                data-message-id="<?= $msg->id ?>"
                                data-is-read="<?= $msg->is_read ?>">
                            <?= $msg->is_read ? 'Mark as Unread' : 'Mark as Read' ?>
                        </button>
                    <?php else: ?>
                        <button class="delete-message-btn" data-message-id="<?= $msg->id ?>">Delete</button>
                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-read-btn').forEach(button => {
            button.addEventListener('click', () => {
                const messageId = button.dataset.messageId;
                const isRead = parseInt(button.dataset.isRead);

                fetch('logika/markRead.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${messageId}&read=${isRead ? 0 : 1}`
                })
                    .then(res => res.text())
                    .then(result => {
                        if (result === 'success') {
                            button.textContent = isRead ? 'Mark as Read' : 'Mark as Unread';
                            button.dataset.isRead = isRead ? '0' : '1';
                        } else {
                            alert('Error updating read status.');
                        }
                    });
            });
        });

        // Delete message
        document.querySelectorAll('.delete-message-btn').forEach(button => {
            button.addEventListener('click', () => {
                const messageId = button.dataset.messageId;

                if (confirm("Are you sure you want to delete this message?")) {
                    fetch('logika/deleteMessage.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id=${messageId}`
                    })
                        .then(res => res.text())
                        .then(result => {
                            if (result === 'success') {
                                document.querySelector(`[data-message-id="${messageId}"]`).remove();
                            } else {
                                alert('Error deleting message.');
                            }
                        });
                }
            });
        });
    });
</script>

</body>
</html>
