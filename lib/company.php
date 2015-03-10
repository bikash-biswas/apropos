<?php 
 class Company {
	private $id;
	private $company;
	private $company_short;
	private $units =array();
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
			$this->id=$id;
	}
	public function getCompany() {
		return $this->company==NULL?"Unmapped":$this->company;
	}
	public function setCompany($company) {
		$this->company=$company;
	}
 	public function getCompanyShort() {
		return $this->company_short==NULL?"Unmapped":$this->company_short;
	}
	public function setCompanyShort($company_short) {
		$this->company_short=$company_short;
	}
	public function addUnit($unit){
		array_push($this->units,$unit);
	}
	public function getUnits() {
		return $this->units;
	}
 }
 ?>