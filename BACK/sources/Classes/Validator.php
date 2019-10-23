<?php
/**
* Validator Class : On valide Quoi que ce soit!
*/
class Validator
{

	private $response;

	/**
	 * Initialization of the function
	 */
	public function __construct()
	{
		$this->response = [];
	}

	public function emptyString(string $value) {
		return isset($value) && (strlen(preg_replace('/\s+/', '', $value)) < 1);
	}

	/**
	 * Look if var is empty
	 * @param  [string|array|integer]  $qqch
	 * @param  [string]  $name hydrate the response
	 */
	public function isEmpty(string $qqch, string $name = '')
	{
		if($this->emptyString($qqch)){
			array_push($this->response, $name . ' doit être renseigné');
		}
	}

	/**
	 * Look if value is email
	 * @param  [string]  $qqch
	 * @param  [string]  $name hydrate the response
	 */
	public function isEmail(string $qqch, string $name = '')
	{
		if($this->emptyString($qqch)){
			array_push($this->response, $name . ' doit être renseigné');
		} else if (!filter_var($qqch, FILTER_VALIDATE_EMAIL)) {
			array_push($this->response, $name . ' renseigné est invalide');
		}
	}

	/**
	 * Look strength password and if passwords are equals
	 * @param  [string]  $pass
	 * @param  [string | null]  $pass2
	 */
	public function isPassword(string $password, string $passwordVerify = null, bool $checkStrength = false)
	{
		if ($this->emptyString($qqch)) {
			array_push($this->response, 'Le mot de passe doit être renseigné');
		} else if ($checkStrength) {

		} else if (!is_null($passwordVerify) && $password !== $passwordVerify) {
			array_push($this->response, 'Les mots de passe ne correspondent pas');
		}
	}

	public function isPhone(string $qqch, string $name = '') {
		if($this->emptyString($qqch)){
			array_push($this->response, $name . ' doit être renseigné');
		} else {
			$s = strlen(preg_replace('/[^\d]+/', '', $value));
			if($s < 8 && $s > 15) {
				array_push($this->response, $name . ' est invalide');
			}
		}
	}

	public function isPostCode(string $qqch, string $name = '') {
		if($this->emptyString($qqch)){
			array_push($this->response, $name . ' doit être renseigné');
		} else if(strlen(preg_replace('/[^\d]+/', '', $value)) < 5) {
			array_push($this->response, $name . ' est invalide');
		}
	}

	/**
	 * Said if the validation is ok or send array of all the error response
	 * @return [bool | array]
	 */
	public function hasErrors()
	{
		return (count($this->response) === 0) ? false : $this->response;
	}

}