<?php

class CommandLine extends Model{

	private $id               = null;
	private $createdDate      = null;
	private $orderedQuantity  = null;
	private $fkCommand        = null;
	private $fkProduct        = null;

	public function getId() {
		return $this->id;
	}
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getOrderedQuantity() {
		return $this->orderedQuantity;
	}
	public function getFkCommand() {
		return $this->fkCommand;
	}
	public function getFkProduct() {
		return $this->fkProduct;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
	public function setOrderedQuantity($orderedQuantity) {
		$this->orderedQuantity = $orderedQuantity;
	}
	public function setFkCommand($fkCommand) {
		$this->fkCommand = $fkCommand;
	}
	public function setFkProduct($fkProduct) {
		$this->fkProduct = $fkProduct;
	}
}