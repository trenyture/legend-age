<?php

class CountryController {

	public function retrieve() {
		$countryManager = new CountryManager();
		echo json_encode($countryManager->get());
		die();
	}

}