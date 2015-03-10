<?PHP
 class Operation {
	private $id;
	private $operation;
	private $validfor;
	private $description;
	private $selected="false";
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id=$id;
	}	
	public function getOperation() {
		return $this->operation;
	}
	public function setOperation($operation) {
		$this->operation=$operation;
	}
	public function getValidfor() {
		return $this->validfor;
	}
	public function setValidfor($validfor) {
		$this->validfor=$validfor;
	}
 	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description=$description;
	}
 	public function isSelected() {
		return $this->selected;
	}
	public function setSelected($selected) {
		$this->selected=$selected;
	}
}
?>