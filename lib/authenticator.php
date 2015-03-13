<?php
require_once("sql.php");
require_once("user.php"); 
require_once("company.php"); 
require_once("unit.php"); 
require_once("util.php"); 
require_once("operation.php"); 
	 
 //Authenticate the User
class Authenticator {

	//Authenticate and populate company and unit for the user
	public static function authenticate($userName,$password){
		//By default user is invalid to access any page.
		$user = new User();
		$user->setValid(false);
		
		$util=new DBUtil();
		$conn=$util->getConnection();
		
		//Validate the user
		$sql = SQLQuery::USER_VALIDATION_SQL;
		$stmt = $conn->prepare( $sql);
		$stmt->bind_param('ss',$userName,$password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$count=$row[0];
		
		//User is valid
		if($count > 0){ //User is valid
			$user->setValid(true); 
			$user->setUserName($userName);
			
			//Get the user informations( First name, Last name, E-mail etc.)
			$sql = SQLQuery::USER_INFO_SQL;
			$stmt = $conn->prepare( $sql);
			$stmt->bind_param('s',$userName);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				while($row = $result->fetch_array()) {
					$user->setFirstName($row["FIRSTNAME"]);
					$user->setLastName($row["LASTNAME"]);
					$user->setUserId($row["ID"]);
					$user->setEmail($row["EMAIL"]);
					$user->setRoleName($row["ROLE"]);
					$user->setCompanyId($row["CID"]);
					$user->setCompanyName($row["COMPANY"]);
					$user->setUnitId($row["UID"]);
					$user->setUnitName($row["UNIT"]);
				}
			}

			$globalOperations=array();
			$companyOperations=array();
			$unitOperations=array();
			
			//Add user actions
			$sql = SQLQuery::USER_OPERATION_SQL;
			$stmt = $conn->prepare( $sql);
			$stmt->bind_param('s',$userName);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				while($row = $result->fetch_array()) {
					$operation=$row["OPERATION"];
					$validFor=$row["VALIDFOR"];
					
					if($validFor=="GLOBAL"){
						array_push($globalOperations,$operation);
					}elseif($validFor=="COMPANY"){
						array_push($companyOperations,$operation);
					}elseif($validFor=="UNIT"){
						array_push($unitOperations,$operation);
					}	
				}
			}
			$user->setActions($globalOperations,"GLOBAL");
			$user->setActions($companyOperations,"COMPANY");
			$user->setActions($unitOperations,"UNIT");
			
			$canViewAllCompanies=$user->isActionAllowed("CAN_VIEW_ALL_COMPANY","GLOBAL");			
			if($canViewAllCompanies){ //If the user can see all companies
				$companies=array();
				$sql = SQLQuery::USER_ADMIN_COMPANY_LIST_SQL;
				$stmt = $conn->prepare( $sql);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						$company=new Company();
						$companyId=$row["CID"];
						$company->setId($companyId);
						$company->setCompany($row["COMPANY"]);
						$company->setCompanyShort($row["COMPANY_SHORT"]);
						
						$alreadyHasCompany=false;
						$matchedCompany=NULL;
						//Check if the Company is already there in company list
						foreach($companies as $listCompany){
							$listCompanyId=$listCompany->getId();
							if($listCompanyId == $companyId){
								$matchedCompany=$listCompany;
								$alreadyHasCompany=true;
							}
						}
						// If the Company is not there in company list add to it
						if($alreadyHasCompany==false){
							$matchedCompany=$company;
							array_push($companies,$company);
						}
						
						//Now create unit and add to company
						$unit=new Unit();
						$unit->setId($row["UID"]);
						$unit->setUnit($row["UNIT"]);
						$unit->setUnitShort($row["UNIT_SHORT"]);
						$matchedCompany->addUnit($unit);
					}
				}
				
				$user->setCompanies($companies);

			}else { //The user can see only his/her company	
				$companies=array();
				$sql = SQLQuery::USER_COMPANY_LIST_SQL;
				$stmt = $conn->prepare( $sql);
				$stmt->bind_param('s',$userName);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						$company=new Company();
						$companyId=$row["CID"];
						$company->setId($companyId);
						$company->setCompany($row["COMPANY"]);
						$company->setCompanyShort($row["COMPANY_SHORT"]);
						
						$alreadyHasCompany=false;
						$matchedCompany=NULL;
						//Check if the Company is already there in company list
						foreach($companies as $listCompany){
							$listCompanyId=$listCompany->getId();
							if($listCompanyId == $companyId){
								$matchedCompany=$listCompany;
								$alreadyHasCompany=true;
							}
						}
						// If the Company is not there in company list add to it
						if($alreadyHasCompany==false){
							$matchedCompany=$company;
							array_push($companies,$company);
						}
						
						//Now create unit and add to company
						$unit=new Unit();
						$unit->setId($row["UID"]);
						$unit->setUnit($row["UNIT"]);
						$unit->setUnitShort($row["UNIT_SHORT"]);
						$matchedCompany->addUnit($unit);
					}
				}
				
				$user->setCompanies($companies);
				
			}//End of normal user
		}//End of user is valid
		$conn->close();
		return $user;
	}
}
?>