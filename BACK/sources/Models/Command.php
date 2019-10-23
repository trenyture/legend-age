<?php

class Command extends Model{

	private $id                  = null;
	private $createdDate         = null;
	private $payedDate           = null;
	private $totalPriceBeforeTax = null;
	private $totalPriceWithTax   = null;
	private $taxAmount           = null;
	private $treatedDate         = null;
	private $sentDate            = null;
	private $archivedDate        = null;
	private $fkAddress           = null;


	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getPayedDate() {
		return $this->payedDate;
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
	public function getArchivedDate() {
		return $this->archivedDate;
	}
	public function getFkAddress() {
		return $this->fkAddress;
	}


	public function setId($id) {
		$this->id = $id;
	}
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
	public function setPayedDate($payedDate) {
		$this->payedDate = $payedDate;
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
	public function setArchivedDate($archivedDate) {
		$this->archivedDate = $archivedDate;
	}
	public function setFkAddress($fkAddress) {
		$this->fkAddress = $fkAddress;
	}

}