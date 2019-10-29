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
				$this->db = new PDO(
					'mysql:host='.DB_HOST.';dbname='.DB_NAME,
					DB_USER,
					DB_PWD,
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
				);
			} catch(Exception $e) {
				http_response_code(400);
				throw $e;
			}
		}
	}
}