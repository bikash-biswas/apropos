<?php
	header('Content-Type: application/json');
	require_once("util.php");
	require_once("sql.php");
	require_once("role.php");
	require_once("managerole.php");
	require_once("manageoperation.php");
?>

<?php 

$roleManager=new ManageRoles();

if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	$responseJson="";
	
	//Get the fulldetils of roles(for display in table)
	if (array_key_exists("fulldetails",$_REQUEST)){
		$roles=$roleManager->getRoles();
		
		$responseJson .="[";
		
		if(count($roles)==0){
			$role=$roles[0];
			$responseJson .="{";
			$responseJson .= '"id":"' .$role->getId() .'",';
			$responseJson .= '"role":"' .$role->getRole() .'",';
			$responseJson .= '"description":"' .$role->getDescription() .'"';
			$responseJson .="}";
				
		}else {
			foreach($roles as $role){
				$responseJson .="{";
				$responseJson .= '"id":"' .$role->getId() .'",';
				$responseJson .= '"role":"' .$role->getRole() .'",';
				$responseJson .= '"description":"' .$role->getDescription() .'"';
				$responseJson .="},";
			}
			$responseJson=substr($responseJson,0,strlen($responseJson)-1);
		}
		$responseJson .="]"; 
	}else {//for update & delete operation, get the information about the selected role
		if (array_key_exists("key",$_REQUEST)){
			$rolePK= $_REQUEST["key"];
			$role=$roleManager->getRole($rolePK);
			$roleId=$role->getId();
			$roleName=$role->getRole();
			$roleDescription=$role->getDescription();
			
				//Create the operations JSON
			$operations=$roleManager->getAllOperationsMappedToRole($rolePK);
			$operationsJsonList=array();
			foreach($operations as $operation){
				$operationsJsonString ='{';
				$operationsJsonString .= '"value":"' .$operation->getId() .'",';
				$operationsJsonString .= '"checked":"' .$operation->isSelected() .'",';
				$operationsJsonString .= '"text":"' .$operation->getDescription() .'"';
				$operationsJsonString .='}';
				array_push($operationsJsonList,$operationsJsonString);
			}
			$opjsonStr=implode(",",$operationsJsonList);
			
			$responseJson='[{"id":"role_name","label":"Role","display":"true","value":"' .$roleName .'","type":"input_text"} ,{"id":"role_description","label":"Description","display":"true","value":"' .$roleDescription .'","type":"input_text"},{"id":"operation_list","label":"Operations","display":"true","type":"checkbox_group","value":[' .$opjsonStr .']}]';

		}else {//For create operation
			$operationManager=new ManageOperations();
			$operations=$operationManager->getOperations();
			$operationsJsonList=array();
			foreach($operations as $operation){
				$operationsJsonString ='{';
				$operationsJsonString .= '"value":"' .$operation->getId() .'",';
				$operationsJsonString .= '"text":"' .$operation->getDescription() .'"';
				$operationsJsonString .='}';
				array_push($operationsJsonList,$operationsJsonString);
			}
			$opjsonStr=implode(",",$operationsJsonList);
			$responseJson='[{"id":"role_name","label":"Role","display":"true","type":"input_text"}, {"id":"role_description","label":"Description","display":"true","type":"input_text"},{"id":"operation_list","label":"Operations","display":"true","type":"checkbox_group","value":[' .$opjsonStr .']}]';
		}
	}
	echo $responseJson;
} elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
	if (array_key_exists("action",$_REQUEST)){
		$action= $_REQUEST["action"];
		
		$success ='{"status" :"success"}';
		$failure ='{"status" :"faiure"}';
		$status=true;
		if($action=="create"){
			$status=$roleManager->addRole($_REQUEST["role_name"],$_REQUEST["role_description"],isset($_REQUEST["operation_list"])?$_REQUEST["operation_list"]:null);
			if($status){echo $success;}
			else {echo $failure;}
		}elseif($action=="update"){
			$status=$roleManager->updateRole($_REQUEST["key"],$_REQUEST["role_name"],$_REQUEST["role_description"],isset($_REQUEST["operation_list"])?$_REQUEST["operation_list"]:null);
			if($status){echo $success;}
			else {echo $failure;}
		}else if($action=="delete"){
			$status=$roleManager->deleteRole($_REQUEST["key"]);
			if($status){echo $success;}
			else {echo $failure;}
		}else{
			echo $failure;
		}
		
	}else{
		echo $failure;
	}
}
?>