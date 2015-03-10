<?PHP

require_once("util.php"); 
require_once("sql.php"); 
require_once("operation.php"); 

class ManageOperations {
		
	public function addOperation($operation,$validfor,$description){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::OPERATION_ADD;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('sss',$operation,$validfor,$description);
		$status=$stmt->execute();
		$conn->commit();
		$conn->close();
	
		return $status;
	}
	public  function updateOperation($id,$operation,$validfor,$description){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::OPERATION_UPDATE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('sssd',$operation,$validfor,$description,$id);
		$status=$stmt->execute();
		$conn->commit();
		$conn->close();
		return $status;
	}
	public function deleteOperation($id){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::OPERATION_DELETE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		$conn->commit();
		$conn->close();
		return $status;
	}
	public function getOperations(){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::OPERATION_LIST;
		$stmt = $conn->prepare( $sql);
		$status=$stmt->execute();
		$operations=array();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$operation=new Operation();
				$operation->setId($row["ID"]);
				$operation->setOperation($row["OPERATION"]);
				$operation->setValidfor($row["VALIDFOR"]);
				$operation->setDescription($row["DESCRIPTION"]);
				array_push($operations,$operation);
			}
		}
		$conn->close();
		return $operations;
	}
	public function getOperation($roleId){
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::OPERATION_FIND;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$roleId);
		$status=$stmt->execute();
		$operation=NULL;
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				$operation=new Operation();
				$operation->setOperation($row["OPERATION"]);
				$operation->setValidfor($row["VALIDFOR"]);
				$operation->setDescription($row["DESCRIPTION"]);
			}
		}
		$conn->close();
		return $operation;
	}

}
?>