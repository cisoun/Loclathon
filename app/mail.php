<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('vendor/autoload.php');

class Mail {
	/**
	 * Send a mail.
	 *
	 * Example:
	 *
	 * 	Mail::send([
	 *		'host'       => '127.0.0.1',
	 *		'user'       => 'mail',
	 *		'password'   => '...',
	 *      'subject'    => 'Hello world!',
	 *      'body'       => '...',
	 *		'from'       => 'me@example.com',
	 *		'from_title' => 'Jane Doe',
	 *		'to'         => ['john@example.com', ...],
	 *		'bcc'        => ['nate@example.com', ...],
	 *		// Treat the mail as html.
	 *	    'html'       => true,
	 *	]);
	 *
	 * @param array $params Parameters of the mail (see above).
	 */
	public static function send($params)
	{
	    // Instantiation and passing `true` enables exceptions.
	    $mail = new PHPMailer(true);

	    // Server settings
	    $mail->isSMTP();
	    $mail->Host       = $params['host'];
	    $mail->Username   = $params['user'];
	    $mail->Password   = $params['password'];
	    $mail->SMTPAuth   = true;
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	    $mail->Port       = 587;

	    // Make it quicker.
	    $mail->SMTPOptions = array(
			'ssl' => array('verify_peer_name' => false)
		);

	    // Add sender.
	    $mail->setFrom($params['from'], $params['from_title']);

		// Add recipients.
		foreach ($params['to'] as $recipient) {
	    	$mail->addAddress($recipient);
		}

	    // Add agents.
	    foreach ($params['bcc'] as $agent) {
	        $mail->addBCC($agent);
	    }

	    // Content
	    $mail->isHTML($params['html']);
	    $mail->Subject = $params['subject'];
	    $mail->Body    = $params['body'];

	    $mail->send();
	}
}
?>
