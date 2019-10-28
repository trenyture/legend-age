<?php

class Address extends Model{

	private $id                   = null;
	private $label                = null;
	private $recipient            = null;
	private $street               = null;
	private $complement           = null;
	private $deliveryInstructions = null;
	private $postcode             = null;
	private $city                 = null;
	private $phoneNumber          = null;
	private $createdDate          = null;
	private $archivedDate         = null;
	private $fkCountry            = null;

	public function getId() {
		return $this->id;
	}
	public function getLabel() {
		return $this->label;
	}
	public function getRecipient() {
		return $this->recipient;
	}
	public function getStreet() {
		return $this->street;
	}
	public function getComplement() {
		return $this->complement;
	}
	public function getDeliveryInstructions() {
		return $this->deliveryInstructions;
	}
	public function getPostcode() {
		return $this->postcode;
	}
	public function getCity() {
		return $this->city;
	}
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getArchivedDate() {
		return $this->archivedDate;
	}
	public function getFkCountry() {
		return $this->fkCountry;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setLabel($label) {
		$this->label = $label;
	}
	public function setRecipient($recipient) {
		$this->recipient = $recipient;
	}
	public function setStreet($street) {
		$this->street = $street;
	}
	public function setComplement($complement) {
		$this->complement = $complement;
	}
	public function setDeliveryInstructions($deliveryInstructions) {
		$this->deliveryInstructions = $deliveryInstructions;
	}
	public function setPostcode($postcode) {
		$this->postcode = $postcode;
	}
	public function setCity($city) {
		$this->city = $city;
	}
	public function setPhoneNumber($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
	public function setArchivedDate($archivedDate) {
		$this->archivedDate = $archivedDate;
	}
	public function setFkCountry($fkCountry) {
		$this->fkCountry = $fkCountry;
	}
}