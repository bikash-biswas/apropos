<!DOCTYPE html>
<?PHP
require_once("lib/user.php"); 
require_once("lib/company.php"); 
require_once("lib/unit.php"); 
session_start();

$key ="user";
$user=null;

if(array_key_exists ($key, $_SESSION)){
	$user= unserialize($_SESSION[$key]);
}else {
	header("Location: login.php");
}
?>
<html>
	<head>
		<meta charset="utf-8" />
			<link rel="shortcut icon" href="compliance.ico" />
			<link rel="stylesheet" type="text/css" href="css/jqueryslidemenu.css" />
			<link rel="stylesheet" type="text/css" href="css/styles.css" />
			<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
			<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css" />
			<link rel="stylesheet" type="text/css" href="css/themes/smoothness/jquery-ui.min.css" />
			<link rel="stylesheet" type="text/css" href="css/sprite.css" />
			<link rel="stylesheet" type="text/css" href="css/jquery.jscrollpane.css"/>

			<!--[if lte IE 7]>
			<style type="text/css">
				html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
			</style>
			<![endif]-->
			<script type="text/javascript" src="js/jquery.js"></script>
			<script type="text/javascript" src="js/jqueryslidemenu.js"></script>
			<script type="text/javascript" src="js/compliance.js"></script>
			<script type="text/javascript" src="js/jquery-ui.min.js"></script>
			<script type="text/javascript" src="js/company.js"></script>
			<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
			<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>

	</head>
	<body>
	
<div class="headercontent">
<?php
	include("menu.php");  
	include("companyunit.php");
?>
</div>
<!-- End of header -->
