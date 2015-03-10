<?PHP
	require_once("lib/user.php"); 
	require_once("lib/unit.php"); 
	require_once("lib/company.php"); 
	
	$user=unserialize($_SESSION["user"]);
	$userName=$user->getUserName();
	$activeUnitName=$user->getActiveUnitName();
	$activeCompanyName=$user->getActiveCompanyName();

?>

<div id="companyunitdetail" class ="headerspan" style="margin-left:auto; margin-right:0; width:40%;">  
 <div class="reporttable" style="display:table;">
	<div style="display:table-row">
		<div style="display:table-cell;padding-left: 10px;"><font class="smallbold goldText">User</font></div><div style="display:table-cell;padding-left: 5px;"><font class="smallnormal goldText"><?PHP echo $userName; ?></font></div>
		<div style="padding-left: 10px;">|</div>
		<div style="display:table-cell;padding-left: 10px;"><font class="smallbold goldText">Company</font></div><div style="display:table-cell;padding-left: 5px;"><font class="smallnormal goldText"><div id="selectedCompanyName"><?PHP echo $activeCompanyName; ?></div></font></div>
		<div style="padding-left: 10px;">|</div>
		<div style="display:table-cell;padding-left: 10px;"><font class="smallbold goldText">Unit</font></div><div style="display:table-cell;padding-left: 5px;"><font class="smallnormal goldText"><div id="selectedUnitName"><?PHP echo $activeUnitName; ?></div></font></div>
	</div>
 </div>
</div>
