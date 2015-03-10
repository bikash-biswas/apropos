 <?php
 class Unit {
 	private $id;
	private $unit;
	private $unit_short;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function getUnit() {
		return $this->unit==NULL?'Unmapped':$this->unit;
	}
	public function setUnit($unit) {
		$this->unit=$unit;
	}
 	public function getUnitShort() {
		return $this->unit_shortunit==NULL?'Unmapped':$this->unit_shortunit;
	}
	public function setUnitShort($unit_short) {
		$this->unit_short=$unit_short;
	}
}
?>