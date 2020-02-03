<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST, PUT, POST, HEAD, OPTIONS, DELETE');

	try {
		define('ROOT', dirname(dirname(__FILE__)));
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
		define('ENV', $config['env']);
		define('STRIPE_PRIVATE_KEY', $config['stripePrivateKey']);
		define('PAYPAL_PRIVATE_KEY', $config['paypalPrivateKey']);
		define('PAYPAL_CLIENT_ID', $config['paypalClientId']);
		define('FRONT_URL', $config['frontUrl']);

		$isBlackFriday = false;
		$promo = 4.01;
		$now = strtotime(date('Y-m-d H:i:s'));
		if($now >= strtotime('2020-01-08 00:00:00') && $now < strtotime('2020-02-02 00:00:00')) {
			$isBlackFriday = true;
			$promo = 9.01;
		}


		define('PROMO', $promo);
		define('ISBLACKFRIDAY', $isBlackFriday);

		/* On inclut l'autoloader de nos dépendances, classes et controller */
		require_once __DIR__.'/../autoloader.php';

	} catch (Exception $e) {
		var_dump($e);
		die();
	}


?>
