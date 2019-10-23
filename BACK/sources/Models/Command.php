<?php

class Command extends Model{

	private $id = null;
	private $creationDate = null;
	private $paymentDate = null;
	private $totalPriceBeforeTax = null;
	private $totalPriceWithTax = null;
	private $taxAmount = null;
	private $treatedDate = null;
	private $sentDate = null;
	private $archivingDate = null;

	public function getId() {
		return $this->id;
	}

	public function getCreationDate() {
		return $this->creationDate;
	}

	public function getPaymentDate() {
		return $this->paymentDate;
	}

	public function getTotalPriceBeforeTax() {
		return $this->totalPriceBeforeTax;
	}

	public function getTotalPriceWithTax() {
		return $this->totalPriceWithTax;
	}

	public function getTaxAmount() {
		return $this->taxAmount;
	}

	public function getTreatedDate() {
		return $this->treatedDate;
	}

	public function getSentDate() {
		return $this->sentDate;
	}

	public function getArchivingDate() {
		return $this->archivingDate;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setCreationDate($creationDate) {
		$this->creationDate = $creationDate;
	}

	public function setPaymentDate($paymentDate) {
		$this->paymentDate = $paymentDate;
	}

	public function setTotalPriceBeforeTax($totalPriceBeforeTax) {
		$this->totalPriceBeforeTax = $totalPriceBeforeTax;
	}

	public function setTotalPriceWithTax($totalPriceWithTax) {
		$this->totalPriceWithTax = $totalPriceWithTax;
	}

	public function setTaxAmount($taxAmount) {
		$this->taxAmount = $taxAmount;
	}

	public function setTreatedDate($treatedDate) {
		$this->treatedDate = $treatedDate;
	}

	public function setSentDate($sentDate) {
		$this->sentDate = $sentDate;
	}

	public function setArchivingDate($archivingDate) {
		$this->archivingDate = $archivingDate;
	}


}