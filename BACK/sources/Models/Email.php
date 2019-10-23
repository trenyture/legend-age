<?php

class Email extends Model{
	private $id;
	private $sender;
	private $alias;
	private $recipient;
	private $subject;
	private $message;
	private $error;
	private $sentDate;
	private $fkEmailStatus;

	/**
	 * GETTERS
	 */
	public function getId() {
		return $this->id;
	}

	public function getSender() {
		return $this->sender;
	}

	public function getAlias() {
		return $this->alias;
	}

	public function getRecipient() {
		return $this->recipient;
	}

	public function getSubject() {
		return $this->subject;
	}

	public function getMessage() {
		return $this->message;
	}

	public function getError() {
		return $this->error;
	}

	public function getSentDate() {
		return $this->sentDate;
	}

	public function getFkEmailStatus() {
		return $this->fkEmailStatus;
	}

	/**
	 * SETTERS
	 */
	public function setId($id) {
		$this->id = $id;
	}

	public function setSender($sender) {
		$this->sender = $sender;
	}

	public function setAlias($alias) {
		$this->alias = $alias;
	}

	public function setRecipient($recipient) {
		$this->recipient = $recipient;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function setError($error) {
		$this->error = $error;
	}

	public function setSentDate($sentDate) {
		$this->sentDate = $sentDate;
	}

	public function setFkEmailStatus($fkEmailStatus) {
		$this->fkEmailStatus = $fkEmailStatus;
	}
}