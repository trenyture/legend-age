<?php
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
	

?>
