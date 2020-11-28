<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('vendor/autoload.php');
require_once('config.php');

function mail_send($subject, $to, $body, $html = false)
{
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();
    $mail->Host       = $CONFIG['mail_host'];
    $mail->Username   = $CONFIG['mail'];
    $mail->Password   = $CONFIG['mail_password'];
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Make it quicker.
    $mail->SMTPOptions = array('ssl' => array('verify_peer_name' => false));

    // Recipients
    $mail->setFrom($CONFIG['mail'], $CONFIG['title']);
    $mail->addAddress($to);

    // Add the agents.
    foreach ($CONFIG['agents'] as $agent) {
        $mail->addBCC($agent);
    }

    // Content
    $mail->isHTML($html);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
}
?>
