<?php
	header('Content-Type: application/json');
	require_once("user.php");
	require_once("company.php");
	require_once("unit.php");
	require_once("manageuser.php");
	
?>

<?php 

$userManager=new ManageUsers();

if($_SERVER['REQUEST_METHOD'] == "GET"){
	
	$responseJson="";
	
	//Get the fulldetils of roles(for display in table)
	if (array_key_exists("fulldetails",$_REQUEST)){
		$users=$userManager->getUsers();
		
		$responseJson .="[";
		
		if(count($users)==0){
			$user=$users[0];
			$responseJson .="{";
			$responseJson .= '"id":"' .$user->getUserId() .'",';
			$responseJson .= '"userName":"' .$user->getUserName() .'",';
			$responseJson .= '"firstName":"' .$user->getFirstName() .'",';
			$responseJson .= '"lastName":"' .$user->getLastName() .'",';
			$responseJson .= '"email":"' .$user->getEmail() .'",';
			$responseJson .= '"company":"' .$user->getCompanyName() .'",';
			$responseJson .= '"unit":"' .$user->getUnitName() .'",';
			$responseJson .= '"role":"' .$user->getRoleName() .'"';
			$responseJson .="}";
				
		}else {
			foreach($users as $user){
				$responseJson .="{";
				$responseJson .= '"id":"' .$user->getUserId() .'",';
				$responseJson .= '"userName":"' .$user->getUserName() .'",';
				$responseJson .= '"firstName":"' .$user->getFirstName() .'",';
				$responseJson .= '"lastName":"' .$user->getLastName() .'",';
				$responseJson .= '"email":"' .$user->getEmail() .'",';
				$responseJson .= '"company":"' .$user->getCompanyName() .'",';
				$responseJson .= '"unit":"' .$user->getUnitName() .'",';
				$responseJson .= '"role":"' .$user->getRoleName() .'"';
				$responseJson .="},";
			}
			$responseJson=substr($responseJson,0,strlen($responseJson)-1);
		}
		$responseJson .="]"; 
	}else {//for update & delete operation, get the information about the selected role
		if (array_key_exists("key",$_REQUEST)){
			$userPK= $_REQUEST["key"];
			$user=$userManager->getUser($userPK);
			$userId=$user->getUserId();
			$user_name=$user->getUserName();
			$first_name=$user->getFirstName();
			$last_name=$user->getLastName();
			$email=$user->getEmail();
			
			$responseJson='[
				{"id":"user_name","label":"User Name","display":"true","value":"' .$user_name .'","type":"input_text"},
				{"id":"first_name","label":"First Name","display":"true","value":"' .$first_name .'","type":"input_text"},
				{"id":"last_name","label":"Last Name","display":"true","value":"' .$last_name .'","type":"input_text"},
				{"id":"email","label":"Email","display":"true","value":"' .$email .'","type":"input_text"}
			]';

		}else {//For create operation
			$responseJson='[
				{"id":"user_name","label":"User Name","display":"true","type":"input_text"},
				{"id":"first_name","label":"First Name","display":"true","type":"input_text"},
				{"id":"last_name","label":"Last Name","display":"true","type":"input_text"},
				{"id":"email","label":"Email","display":"true","type":"input_text"}
			]';
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
			$status=$userManager->addUser($_REQUEST["user_name"],$_REQUEST["first_name"],$_REQUEST["last_name"],$_REQUEST["email"]);
			if($status){echo $success;}
			else {echo $failure;}
		}elseif($action=="update"){
			$status=$userManager->updateUser($_REQUEST["key"],$_REQUEST["user_name"],$_REQUEST["first_name"],$_REQUEST["last_name"],$_REQUEST["email"]);
			if($status){echo $success;}
			else {echo $failure;}
		}else if($action=="delete"){
			$status=$userManager->deleteUser($_REQUEST["key"]);
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