<?php


class Manager {

	public $db = null;

	/**
	 * Initialization of the function
	 */
	public function __construct(){
		$this->getInstance();
	}

	private function getInstance() {
		if(is_null($this->db)) {
			try {
				$config = json_decode(file_get_contents(getcwd() . "/../config.json"), true);
				$this->db = new PDO('mysql:host='.$config["host"].';dbname='.$config["bdd"], $config["user"], $config["pass"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			} catch(Exception $e) {
				http_response_code(400);
				throw $e;
			}
		}
	}
}