<?php
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	header("Access-Control-Allow-Origin: *");

	try {
		define('ROOT', getcwd());
		/*ON CHARGE NOTRE CONFIGURATION*/
		$config = json_decode(file_get_contents(ROOT.'/config.json'), true);
		
		if($config['env'] != "prod"){
			/* On affiche les erreurs PHP pour l'environnement de dev */
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}

		/* On initialise les variables de session */
		session_start();
		define('DB_HOST', $config['host']);
		define('DB_NAME', $config['bdd']);
		define('DB_USER', $config['user']);
		define('DB_PWD', $config['pass']);
		define('EMAIL_ACCOUNT', $config['email']);
		define('EMAIL_PASSWD', $config['email_passwd']);
		define('ENV', $config['env']);

	} catch (Exception $e) {
		var_dump($e);
		die();
	}

	spl_autoload_register(
		function ($class) {
			if (file_exists(ROOT.'/sources/Classes/' . $class . '.php')) {
				include ROOT.'/sources/Classes/' . $class . '.php';
			} elseif (file_exists(ROOT.'/sources/Controllers/' . $class . '.php')) {
				include ROOT.'/sources/Controllers/' . $class . '.php';
			} elseif (file_exists(ROOT.'/sources/Models/' . $class . '.php')) {
				include ROOT.'/sources/Models/' . $class . '.php';
			} elseif (file_exists(ROOT.'/sources/Managers/' . $class . '.php')) {
				include ROOT.'/sources/Managers/' . $class . '.php';
			}
		}
	);

	// On commence notre CRON : 

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'user@example.com';                     // SMTP username
	    $mail->Password   = 'secret';                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	    $mail->Port       = 587;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('from@example.com', 'Mailer');
	    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	    $mail->addAddress('ellen@example.com');               // Name is optional
	    $mail->addReplyTo('info@example.com', 'Information');
	    $mail->addCC('cc@example.com');
	    $mail->addBCC('bcc@example.com');

	    // Attachments
	    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Here is the subject';
	    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	    echo 'Message has been sent';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
