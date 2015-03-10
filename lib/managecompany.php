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
	//var_dump($user);

?>

<?php 
if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	$companies=array();
	$responseJson="";
	
	//Get the fulldetils of company(for display in table)
	if (array_key_exists("fulldetails",$_REQUEST)){
		$companies=$user->getCompanies();
		
		$responseJson .="[";
		
		if(count($companies)==0){
			$company=$companies[0];
			$responseJson .="{";
			$responseJson .= '"id":"' .$company->getId() .'",';
			$responseJson .= '"shortname":"' .$company->getCompanyShort() .'",';
			$responseJson .= '"companyname":"' .$company->getCompany() .'"';
			$responseJson .="}";
				
		}else {
			foreach($companies as $company){
				$responseJson .="{";
				$responseJson .= '"id":"' .$company->getId() .'",';
				$responseJson .= '"shortname":"' .$company->getCompanyShort() .'",';
				$responseJson .= '"companyname":"' .$company->getCompany() .'"';
				$responseJson .="},";
			}
			$responseJson=substr($responseJson,0,strlen($responseJson)-1);
		}
		$responseJson .="]"; 
	}else {//for update & delete operation, get the information about the selected company
		if (array_key_exists("key",$_REQUEST)){
			$companyPK= $_REQUEST["key"];
			$company=$user->getCompany($companyPK);
			$companyId=$company->getId();
			$companyName=$company->getCompany();
			$companyShort=$company->getCompanyShort();
			
			$responseJson='[{"id":"company_short","label":"Company Short Name","display":"true","value":"' .$companyShort .'","type":"input_text"} ,{"id":"company_name","label":"Company Name","display":"true","value":"' .$companyName .'","type":"input_text"}]';

		}else {//For create operation
			$responseJson='[{"id":"company_short","label":"Company Short Name","display":"true","type":"input_text"}, {"id":"company_name","label":"Company Name","display":"true","type":"input_text"}]';
		}
	}
	echo $responseJson;
} elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
	if (array_key_exists("action",$_REQUEST)){
		$action= $_REQUEST["action"];
		
		$success ='{"status" :"success"}';
		$failure ='{"status" :"faiure"}';
		
		if($action=="create"){
			$companyManager=new ManageCompany($user);
			$status=$companyManager->addCompany($_REQUEST["company_name"],$_REQUEST["company_short"]);
			if($status){echo $success;}
			else {echo $failure;}
		}elseif($action=="update"){
			$companyManager=new ManageCompany($user);
			$status=$companyManager->updateCompany($_REQUEST["key"],$_REQUEST["company_name"],$_REQUEST["company_short"]);
			if($status){echo $success;}
			else {echo $failure;}
		}else if($action=="delete"){
			$companyManager=new ManageCompany($user);
			$status=$companyManager->deleteCompany($_REQUEST["key"]);
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


class ManageCompany {
	private $user;
	
	public function __construct($user){
		$this->user=$user;
	}
	public  function addCompany($company,$companyShort){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::COMPANY_ADD;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('ss',$companyShort,$company);
		$status=$stmt->execute();
		
		if($status==true){
			$companyId=mysqli_insert_id($conn);
			$user=$user->addCompany($companyId,$company,$companyShort);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	public  function updateCompany($id,$company,$companyShort){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::COMPANY_UPDATE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('ssd',$companyShort,$company,$id);
		$status=$stmt->execute();
		if($status==true){
			$user=$user->updateCompany($id,$company,$companyShort);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	public function deleteCompany($id){
		$user=$this->user;
		$util=new DBUtil();
		$conn=$util->getConnection();
		$sql = SQLQuery::COMPANY_DELETE;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('d',$id);
		$status=$stmt->execute();
		if($status==true){
			$user=$user->deleteCompany($id);
			$_SESSION["user"]= serialize($user);
		}
		$conn->commit();
		$conn->close();
		return $status;
	}
	
}


?>