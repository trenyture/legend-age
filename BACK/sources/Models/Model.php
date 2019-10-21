<?php

class Model {
	public function __construct($datas)
	{
		$this->_hydrate($datas);
	}

	private function _hydrate($datas) {
		foreach ($datas as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}
}