 <?php
header('Content-Type: application/json');

require_once("util.php");
require_once("sql.php");

require_once("user.php"); 
require_once("company.php"); 
require_once("unit.php"); 
session_start();

$key ="user";
$user=null;

$user= unserialize($_SESSION[$key]);

if($_SERVER['REQUEST_METHOD'] == "GET"){
	$units=array();
	$responseJson="";
	//Get the fulldetils of company(for display in table)
	if (array_key_exists("fulldetails",$_REQUEST)){
		
		$units=$user->getUnitList();
		$responseJson .="[";

		if(count($units)==0){
			$unit=$units[0];
			$responseJson .="{";
			$responseJson .= '"id":"' .$unit->getId() .'",';
			$responseJson .= '"shortname":"' .$unit->getUnitShort() .'",';
			$responseJson .= '"unitname":"' .$unit->getUnit() .'"';
			$responseJson .="}";
		}else {
			foreach($units as $unit){
				$responseJson .="{";
				$responseJson .= '"id":"' .$unit->getId() .'",';
				$responseJson .= '"shortname":"' .$unit->getUnitShort() .'",';
				$responseJson .= '"unitname":"' .$unit->getUnit() .'"';
				$responseJson .="},";
			}
			$responseJson=substr($responseJson,0,strlen($responseJson)-1);
		}
		$responseJson .="]"; 
	}else {//for update & delete operation, get the information about the selected company
		if (array_key_exists("key",$_REQUEST)){
			$unitPK= $_REQUEST["key"];
			$unit=$user->getUnit($unitPK);
			$unitId=$unit->getId();
			$unitName=$unit->getUnit();
			$unitShort=$unit->getUnitShort();
			
			$responseJson='[{"id":"unit_short","label":"Unit Short Name","display":"true","value":"' .$unitShort .'","type":"input_text"} ,{"id":"unit_name","label":"Unit Name","display":"true","value":"' .$unitName .'","type":"input_text"}]';

		}else {//For create operation
			$companies=$user->getCompanyList();
			$companyStrs=array();
		
			foreach($companies as $company) {
				$companyStr='{"op_value":"' .$company->getId() .'","op_label": "' .$company->getCompanyShort() .'"}';
				array_push($companyStrs,$companyStr);
			}
			$responseJson ='[{ "id":"company_select", "type":"input_select","label":"Company","display":"true", "value" :[' .implode(",",$companyStrs) .']},';

			$responseJson .='{"id":"unit_short","label":"Unit Short Name","display":"true","type":"input_text"}, {"id":"unit_name","label":"Unit Name","display":"true","type":"input_text"}]';
		}
	}
	echo $responseJson;
}elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
	if (array_key_exists("action",$_REQUEST)){
		$action= $_REQUEST["action"];
		
		$success ='{"status" :"success"}';
		$failure ='{"status" :"faiure"}';
		if($action=="create"){
			$unitManager=new ManageUnit($user);
			$status=$unitManager->addUnit($_REQUEST["company_id"],$_REQUEST["unit_name"],$_REQUEST["unit_short"]);
			if($status){echo $success;}
			else {echo $failure;}
		}elseif($action=="update"){
			$unitManager=new ManageUnit($user);
			$status=$unitManager->updateUnit($_REQUEST["key"],$_REQUEST["unit_name"],$_REQUEST["unit_short"]);
			if($status){echo $success;}
			else {echo $failure;}
		}else if($action=="delete"){
			$unitManager=new ManageUnit($user);
			$status=$unitManager->deleteUnit($_REQUEST["key"]);
			if($status){echo $success;}
			else {echo $failure;}
		}else{
			echo $failure;
		}
	}else{
		echo $failure;
	}
}

/*---------------------------------------*/
class ManageUnit {
	private $user;
	
	public function __construct($user){
		$this->user=$user;
	}
	public  function addUnit($companyId,$unit,$unitShort){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::UNIT_ADD;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('dss',$companyId,$unit,$unitShort);
		$status=$stmt->execute();
		
		if($status==true){
			$unitId=mysqli_insert_id($conn);
			$user=$user->addUnit($companyId,$unitId,$unit,$unitShort);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	public  function updateUnit($companyId,$unit,$unitShort,$id){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::UNIT_UPDATE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('dssd',$companyId,$unit,$unitShort,$id);
		$status=$stmt->execute();
		if($status==true){
			$user=$user->updateUnit($companyId,$unitId,$unit,$unitShort);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	public function deleteUnit($id){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::UNIT_DELETE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		if($status==true){
			$user=$user->deleteUnit($id);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	
}
?>