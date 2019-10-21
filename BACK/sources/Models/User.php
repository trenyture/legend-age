<?php

class User extends Model{

	private $id = null;
	private $email = null;
	private $firstname = null;
	private $lastname = null;
	private $birthDate = null;
	private $activationKey = null;
	private $createdDate = null;
	private $archivedDate = null;
	private $newsletter = null;
	private $isAdmin = null;

	/****************************
	***   GETTERS FUNCTIONS   ***
	****************************/
	public function getID() {
		return $this->id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function getLastname() {
		return $this->lastname;
	}

	public function getBirthDate() {
		return $this->birthDate;
	}

	public function getActivationKey() {
		return $this->activationKey;
	}

	public function getCreatedDate() {
		return $this->createdDate;
	}

	public function getArchivedDate() {
		return $this->archivedDate;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getIsAdmin() {
		return $this->isAdmin;
	}

	/****************************
	***   SETTERS FUNCTIONS   ***
	****************************/
	public function setID($id) {
		$this->id = $id;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	public function setBirthDate($birthDate) {
		$this->birthDate = $birthDate;
	}

	public function setActivationKey($activationKey) {
		$this->activationKey = $activationKey;
	}

	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}

	public function setArchivedDate($archivedDate) {
		$this->archivedDate = $archivedDate;
	}

	public function setNewsletter($newsletter) {
		$this->newsletter = $newsletter;
	}

	public function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;
	}

}