<?PHP
	require_once("user.php"); 
	require_once("company.php"); 
	require_once("unit.php"); 

	$returnJson="{";
	$key ="user";
	session_start();
	
	if(array_key_exists ($key, $_SESSION)){
		$user= unserialize($_SESSION[$key]);

		if(array_key_exists ('companyid', $_REQUEST)) {
			$requestCompanyId=$_REQUEST['companyid'];
			$user->setActiveCompanyId($requestCompanyId);
			$companyName=$user->getActiveCompanyName();
			$returnJson .='"companyname" :"' .$companyName .'"';

			if(array_key_exists ('unitid', $_REQUEST)) {
				$returnJson .=',';
				$requestUnitId=$_REQUEST['unitid'];
				$user->setActiveUnitId($requestUnitId);
				$unitName=$user->getActiveUnitName();
				$returnJson .='"unitname" :"' .$unitName .'"';
			}else{
				$user->setActiveUnitId(NULL);
			}
		}else {
			$user->setActiveCompanyId(NULL);
		}

		
		$returnJson .="}";
		$_SESSION["user"]= serialize($user);
		
		
		echo $returnJson;
	}
?>