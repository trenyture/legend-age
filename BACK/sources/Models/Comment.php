<?php

class Comment extends Model{

	private $id            = null;
	private $firstname     = null;
	private $lastname      = null;
	private $message       = null;
	private $notation      = null;
	private $createdDate   = null;
	private $validatedDate = null;
	private $archivedDate  = null;

	/**
	 * GETTERS
	 */
	public function getId() {
		return $this->id;
	}
	public function getFirstname() {
		return $this->firstname;
	}
	public function getLastname() {
		return $this->lastname;
	}
	public function getNotation() {
		return $this->notation;
	}
	public function getMessage() {
		return $this->message;
	}
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getValidatedDate() {
		return $this->validatedDate;
	}
	public function getArchivedDate() {
		return $this->archivedDate;
	}

	/**
	 * SETTERS
	 */
	public function setId($id) {
		$this->id = $id;
	}
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	public function setNotation($notation) {
		$this->notation = $notation;
	}
	public function setMessage($message) {
		$this->message = $message;
	}
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
	public function setValidatedDate($validatedDate) {
		$this->validatedDate = $validatedDate;
	}
	public function setArchivedDate($archivedDate) {
		$this->archivedDate = $archivedDate;
	}
}