<?php

class Manager {

	public $db = null;

	/**
	 * Initialization of the function
	 */
	private function __construct(){
		$this->getInstance();
	}

	private function getInstance() {
		if(is_null($this->db)) {
			$this->db = "something";
		}
	}
}