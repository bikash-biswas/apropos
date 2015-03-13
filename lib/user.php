<?php

/**
* Defines a user
*
*/
class User {
	private $userName;
	private $companies = array();
	private $activeUnitId;
	private $activeCompanyId;
	private $actions=array();
	private $valid=false;
	private $firstName;
	private $lastName;
	private $email;
	private $roleId;
	private $unitId;
	private $roleName;
	private $unitName;
	private $userId;
	
	
	public function getUserName() {
		return $this->userName;
	}
	public function setUserName($userName) {
		$this->userName=$userName;
	}
	public function getActiveUnitId() {
		return $this->activeUnitId;
	}
	public function setActiveUnitId($activeUnitId) {
		$this->activeUnitId=$activeUnitId;
	}
	public function getActiveCompanyId() {
		return $this->activeCompanyId;
	}
	public function setActiveCompanyId($activeCompanyId) {
		$this->activeCompanyId=$activeCompanyId;
	}
	public function getCompanies() {
		return $this->companies;
	}
	public function setCompanies($companies) {
		$this->companies=$companies;
	}
	public function addAction($action,$level) {
		$levelaction=$this->actions[$level];
		array_push($levelaction , $action);
		$this->setActions($levelaction,$level);
	}
	public function getActions($level) {
		return $this->actions[$level];
	}
	public function setActions($actions,$level) {
		$this->actions[$level]=$actions;
	}
	public function isValid() {
		return $this->valid;
	}
	public function setValid($valid) {
		$this->valid=$valid;
	}
	public function getFirstName() {
		return $this->firstName;
	}
	public function setFirstName($firstName) {
		$this->firstName=$firstName;
	}	
	public function getLastName() {
		return $this->lastName;
	}
	public function setLastName($lastName) {
		$this->lastName=$lastName;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email=$email;
	}
	public function getRoleId() {
		return $this->roleId;
	}
	public function setRoleId($roleId) {
		$this->roleId=$roleId;
	}
	public function getUnitId() {
		return $this->unitId;
	}
	public function setUnitId($unitId) {
		$this->unitId=$unitId;
	}
	public function getRoleName() {
		return $this->roleName;
	}
	public function setRoleId($roleName) {
		$this->roleName=$roleName;
	}
	public function getUnitName() {
		return $this->unitName;
	}
	public function setUnitId($unitName) {
		$this->unitName=$unitName;
	}
	public function getCompany($companyId) {
		$matchedCompany=NULL;
		$companies=$this->getCompanies();
		foreach($companies as $comp){
			$compId=$comp->getId();
			if($compId==$companyId){
				$matchedCompany=$comp;
			}
		}
		return $matchedCompany;
	}
	public function getUnits($companyId) {
		$units=array();
		$comp=$this->getCompany($companyId);
		if(!is_null($comp)){
			$units=$comp->getUnits();
		}
		return $units;
	}
	public function getUnit($companyId,$unitId){
		$matchedUnit=NULL;
		$matchingUnits=$this->getUnits($companyId);
		foreach($matchingUnits as $matchingUnit){
			$matchingUnitId=$matchingUnit->getId();
			if($matchingUnitId==$unitId){
				$matchedUnit=$matchingUnit;
			}
		}
		return $matchedUnit;
	}
	public function getActiveCompanyName(){
		$activeCompanyName="Not Selected";
		$activeCompId=$this->getActiveCompanyId();
		if(!is_null($activeCompId)){
			$activeCompany=$this->getCompany($activeCompId);
			if(!is_null($activeCompany)){
				$activeCompanyName=$activeCompany->getCompany();
			}
		}
		return $activeCompanyName;
	}	
	public function getActiveUnitName(){
		$activeUnitName="Not Selected";
		$activeCompId=$this->getActiveCompanyId();
		$activeUtId=$this->getActiveUnitId();
		if(!is_null($activeCompId) && !is_null($activeUtId)){
			$activeUt=$this->getUnit($activeCompId,$activeUtId);
			if(!is_null($activeUt)){
				$activeUnitName=$activeUt->getUnit();
			}
		}
		return $activeUnitName;
	}
	public function addCompany($companyId,$company,$companyShort){
		$newCompany=new Company();
		$newCompany->setId($companyId);
		$newCompany->setCompany($company);
		$newCompany->setCompanyShort($companyShort);
		array_push ($this->companies,$newCompany);
		return $this;
	}
	public function updateCompany($companyId,$company,$companyShort){
		$modCompany=$this->getCompany($companyId);
		$modCompany->setCompany($company);
		$modCompany->setCompanyShort($companyShort);
		return $this;
	}
	public function deleteCompany($companyId){
		$tempCompanies=array();
		foreach($this->getCompanies() as $tempCompany){
			$tempCompanyId=$tempCompany->getId();
			if($tempCompanyId !=$companyId){
				array_push ($tempCompanies,$tempCompany);
			}
		}
		$this->setCompanies($tempCompanies);
		return $this;
	}
	public function getUnitList(){
		$arguments = func_get_args();
		$argumentsCount = func_num_args();
		$unitsList=array();
		if($argumentsCount ==0){
			foreach($this->getCompanies() as $tempCompany){
				$tempUnits=$tempCompany->getUnits();
				foreach($tempUnits as $tempUnit){
					array_push ($unitsList,$tempUnit);
				}
			}
		}else{
			$selectCompanyId=$arguments[0];
			$selectedCompany=$this->getCompany($selectCompanyId);
			$unitsList=$selectedCompany->getUnits();
		}
		return $unitsList;
	}
	public function isActionAllowed($action, $level){
		$tempActions=$this->getActions($level);
		$matched=false;
		foreach($tempActions as $tempAction){
			if($tempAction == $action){
				$matched=true;
			}
		}
		return $matched;
	}
}
?>