<?php
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	header("Access-Control-Allow-Origin: *");

	try {
		define('ROOT', dirname(__FILE__));
		/*ON CHARGE NOTRE CONFIGURATION*/
		$config = json_decode(file_get_contents(ROOT.'/config.json'), true);

		if($config['env'] != "prod"){
			/* On affiche les erreurs PHP pour l'environnement de dev */
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}

		/* On initialise les variables de session */
		define('DB_HOST', $config['host']);
		define('DB_NAME', $config['bdd']);
		define('DB_USER', $config['user']);
		define('DB_PWD', $config['pass']);
		define('EMAIL_ACCOUNT', $config['email']);
		define('EMAIL_PASSWD', $config['email_passwd']);
		define('ENV', $config['env']);
		define('PROMO', 4.01);

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
	$emailManager = new EmailManager();
	$emails = $emailManager->get(null, 1);

	if(count($emails) > 0) {
		$max = count($emails) > 5 ? 5 : count($emails);
		for ($i=0; $i < $max; $i++) {
			$mail = new Email([
				'id' => $emails[$i]['id'],
				'sender' => $emails[$i]['sender'],
				'alias' => $emails[$i]['alias'],
				'recipient' => $emails[$i]['recipient'],
				'subject' => $emails[$i]['subject'],
				'message' => $emails[$i]['message'],
				'error' => $emails[$i]['error'],
				'sentDate' => $emails[$i]['sent_date'],
				'fkEmailStatus' => $emails[$i]['fk_email_status'],
			]);

			$headers = []

			$headers[] = 'From: ' . $mail->getSender();
			$headers[] = 'Reply-To: '. $mail->getSender();
			$headers[] = 'Bcc: simon.trichereau@gmail.com';
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-Type: text/html; charset=ISO-8859-1';
			$headers[] = 'X-Mailer: PHP/' . phpversion();

			if(mail(
				$mail->getRecipient(),
				$mail->getSubject(),
				$mail->getMessage(),
				implode("\r\n", $headers)
			)) {
				$mail->setSentDate(date('Y-m-d H:i:s'));
				$mail->setFkEmailStatus(2);
			} else {
				$mail->setFkEmailStatus(3);
				$mail->setError(error_get_last()['message']);
			}
			$emailManager->set($mail);
		}
	}
