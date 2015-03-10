<?php
require_once("authenticator.php"); 


if($_SERVER['REQUEST_METHOD'] == "POST"){
	$userName= $_REQUEST["user"];
	$passwd= md5($_REQUEST["passwd"]);
	
	//If user is valid then show overview page otherwise show login page
	try{
		$user=Authenticator::authenticate($userName,$passwd);
		if($user->isValid()){
			session_start();
			$_SESSION["user"]= serialize($user);
			header("Location: ../overview.php");
		}else{
			header("Location: ../index.html");
		}
	}catch(Exception $e){
		header("Location: ../index.html");
	}
}
?>