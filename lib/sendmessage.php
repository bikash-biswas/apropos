<?PHP
	require_once("user.php"); 
	require_once("unit.php"); 
	require_once("company.php"); 

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$subject= urldecode ($_REQUEST["subject"]);
	$message= urldecode ($_REQUEST["message"]);
	
	session_start();
	$key ="user";
	if(array_key_exists ($key, $_SESSION)){
		$user= unserialize($_SESSION[$key]);
		$activeUnit=$user->getActiveUnit();
		if($activeUnit !=null){
			$activeUnitId=$activeUnit->getId();
			$infos=$user->getUserUnitInfo();

			$fromEmail=null;
			foreach($infos as $info){
				$infoUnit=$info->getUnit();
				if($infoUnit->getId() == $activeUnitId){
					$fromEmail= $info->getEmail();
					break;
				}
			}
			if($fromEmail !=null){
				//Read Admin E-mail
				$config_params=parse_ini_file("../conf/apropos.conf");
				$admin_email=$config_params['admin-email'];
				
				//Send E-mail
				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/plain; charset=iso-8859-1";
				$headers[] = "From: <" .$fromEmail .">";
				$headers[] = "Reply-To: <" .$fromEmail .">";
				$headers[] = "Subject: " .$subject;
				echo $admin_email;
				date_default_timezone_set("Asia/Dili");
				$status=mail($admin_email,$subject,$message,implode("\r\n", $headers));
				if($status){
				}
			}else{
				http_response_code(501);
			}
		}else {
			http_response_code(501);
		}
	}
}
?>