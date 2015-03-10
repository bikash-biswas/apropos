<?PHP

require_once("util.php"); 
require_once("sql.php"); 
require_once("role.php"); 
require_once("operation.php"); 

class ManageRoles {
		
	public function addRole($role,$description,$operationIds){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$conn->autocommit(false);
		
		//Add Role
		$sql = SQLQuery::ROLE_ADD;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('ss',$role,$description);
		$status=$stmt->execute();
		$roleId=$conn->insert_id;
		$stmt->close();
		if(isset($operationIds)){
			//Add Role to Operation mapping
			foreach($operationIds as $operationId){
				$sql = SQLQuery::ROLEOPMAPPING_ADD;
				$stmt = $conn->prepare( $sql);
				$stmt->bind_param('dd',$roleId,$operationId);
				$status =$stmt->execute();
			}
			$stmt->close();
		}
		$conn->commit();
		$conn->autocommit(true);
		$conn->close();
		return $status;
	}
	public  function updateRole($id,$role,$description,$operationIds){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$conn->autocommit(false);
		
		$sql = SQLQuery::ROLE_UPDATE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('ssd',$role,$description,$id);
		
		$status=$stmt->execute();
		$stmt->close();
		
		if(isset($operationIds)){
			//Delete Role to Operation mapping
			$sql = SQLQuery::ROLEOPMAPPING_DELETE;
			$stmt = $conn->prepare( $sql);
			$stmt->bind_param('d',$id);
			$status=$stmt->execute();
			$stmt->close();

			//Add Role to Operation mapping
			foreach($operationIds as $operationId){
				$sql = SQLQuery::ROLEOPMAPPING_ADD;
				$stmt = $conn->prepare( $sql);
				$stmt->bind_param('dd',$id,$operationId);
				$status =$stmt->execute();
			}
			$stmt->close();
		}
		$conn->commit();
		$conn->autocommit(true);
		$conn->close();
		return $status;
	}
	public function deleteRole($id){
		$util=new DBUtil();
		$conn=$util->getConnection();
		//Delete Role to Operation mapping
		$sql = SQLQuery::ROLEOPMAPPING_DELETE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		
		//Unset user roles
		$sql = SQLQuery::USERROLE_UNSET;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		
		//Delete the role
		$sql = SQLQuery::ROLE_DELETE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		$conn->commit();
		$conn->close();
		return $status;
	}
	//Get the full list of roles
	public function getRoles(){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::ROLE_LIST;
		$stmt = $conn->prepare( $sql);
		$status=$stmt->execute();
		$roles=array();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$role=new Role();
				$role->setId($row["ID"]);
				$role->setRole($row["ROLE"]);
				$role->setDescription($row["DESCRIPTION"]);
				array_push($roles,$role);
			}
		}
		$conn->close();
		return $roles;
	}
	//Get a particular role
	public function getRole($roleId){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::ROLE_FIND;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$roleId);
		$status=$stmt->execute();
		$role=NULL;
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$role=new Role();
				$role->setId($row["ID"]);
				$role->setRole($row["ROLE"]);
				$role->setDescription($row["DESCRIPTION"]);
			}
		}
		$conn->close();
		return $role;
	}
	//Get the list of Operations mapped to role
	public function getOperationMappedToRole($roleId){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::ROLE_OPERATION_FIND;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$roleId);
		$status=$stmt->execute();
		$role=NULL;
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$role=new Role();
				$role->setId($row["ID"]);
				$role->setRole($row["ROLE"]);
				$role->setDescription($row["DESCRIPTION"]);
			}
		}
		$conn->close();
		return $role;
	}
	public function getAllOperationsMappedToRole($roleId){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::ROLE_OPERATION_FIND;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$roleId);
		$status=$stmt->execute();
		$result = $stmt->get_result();
		$operations=array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$operation=new Operation();
				$operation->setId($row["ID"]);
				$operation->setOperation($row["OPERATION"]);
				$operation->setValidfor($row["VALIDFOR"]);
				$operation->setSelected($row["STATUS"]);
				$operation->setDescription($row["DESCRIPTION"]);
				array_push($operations,$operation);
			}
		}
		$conn->close();
		return $operations;
	}
}
?>