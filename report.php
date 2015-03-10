 <?php
	$pageTitle ="Report";
	
	$reportType= $_REQUEST["type"];
	
	$htmlstring = "";
	if($reportType== "html"){
		include("header.php");
	}else if($reportType== "pdf"){
		session_start();
	}
?>
<?php
	include("create_report.php");
?>
<br/>
<?php
	if($reportType== "html"){
		include("footer.php");
	}
?>
 