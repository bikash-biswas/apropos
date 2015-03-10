<?PHP
class Role {
	private $id;
	private $role;
	private $description;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id=$id;
	}	
	public function getRole() {
		return $this->role;
	}
	public function setRole($role) {
		$this->role=$role;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description=$description;
	}
}
?>