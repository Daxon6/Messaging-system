<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

session_start();

$mailData = $_SESSION['mail'] ?? null;

if (!$mailData) {
    echo "Missing mail data!";
    exit();
}

$mail = new PHPMailer(true);

try {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '05e9a32a87796b';
    $mail->Password = 'e2cca36ec9e0d0';

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->setFrom($mailData['from_email'], $mailData['from_name']);
    $mail->addAddress($mailData['to_email'], $mailData['to_name']);
    $mail->addReplyTo($mailData['from_email'], $mailData['from_name']);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);
    $mail->Subject = $mailData['subject'];
    $mail->Body = $mailData['body'];
    $mail->AltBody = strip_tags($mailData['body']);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
unset($_SESSION['mail']);

header('Refresh: 4; URL=../messages.php');