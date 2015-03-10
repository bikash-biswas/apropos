 <?php
	include("header.php");
?>
<?php
$pageTitle ="View Unit List";


$isCompanySelected=false;
$activeCompanyId=$user->getActiveCompanyId();
if($activeCompanyId !=null){
	$isCompanySelected=true;
}

$isAdmin=false;
$units=null;

if($isAdmin){
		$units=$user->getUnitList();
}else {
	if($isCompanySelected){
		$units=$user->getUnitList($activeCompanyId);
	}
}
?>
<script type="text/javascript" src="js/company.js"></script>

<script type="text/javascript">
function updateDetails(){

	//Delete all rows except the first row(index 0)
	$("#unitdetails > table > tbody > tr").each(function(index){
		if(index > 0){
			$(this).remove();
		}
	});
	//Get the data from backend
	$.getJSON("lib/manageunit.php?fulldetails=yes",function(data,status){
	
		$.each(data, function(counter, unit) {
			var unitId=unit.id;
			var unitShortName=unit.shortname;
			var unitName=unit.companyname;
 
			var bodyelement=$("#unitdetails > table > tbody");
			var updateStr= '<a id="unitid_'+unitId+ '" href="#" onclick="javascript:updateDialog(\'Update Unit\',\'lib/manageunit.php\',\'lib/manageunit.php\',\''+companyId+'\',\'updateDetails()\')"><div class="modify"></div></a>';
			var deleteStr= '<a id="companyid_'+unitId+ '" href="#" onclick="javascript:deleteDialog(\'Delete Unit\',\'lib/manageunit.php\',\'lib/manageunit.php\',\''+unitId+'\',\'updateDetails()\')"><div class="delete"></div></a>';
			var rowString='<tr><td>'+(counter+1) +'</td><td>'+unitShortName+'</td><td>'+unitName+'</td><td>'+updateStr+'</td><td>'+deleteStr+'</td></tr>';
			$(rowString).appendTo(bodyelement);
		});
	});
}
</script>

<div class="maincontent">
<div class="borderedDiv">
	<table style="width:100%">
		<tr>
			<td class="titleText blueheadertext">
				View Unit
			</td>
		</tr>
	</table>
</div>


<!------- Content ---------->
<div class="scroll-pane displaytable" id="unitdetails" style="z-index:10;">
<table class="contenttable" >
	<thead>
		<tr>
			<td style="width:8%">Sl. No.</td>
			<td>Unit Short Name</td>
			<td style="width:50%">Unit Name</td>
			<td style="width:20px">&nbsp;</td>
			<td style="width:20px">&nbsp;</td>
			
		</tr>
	</thead>
	
	<tbody>
<?PHP
$addUnitStr = <<<EOF
	<tr>
		<td colspan="5" style="text-align: right;"><a href="#" onClick="javascript:createDialog('Create Unit', 'lib/manageunit.php','lib/manageunit.php','updateDetails()')"><span>Add Unit</span><div id="addUnit" class="add"></div> </a></td>
	</tr>
EOF;

echo $addUnitStr;

if(count($units)){
	for($i=0;$i < sizeof($units);$i++){
		$unit=$units[$i];
		$unitId=$unit->getId();
		$unitName=$unit->getUnit();
		$unitShortName=$unit->getUnitShort();
		
		echo ("<tr>");
		echo ("<td>" .($i+1) ."</td>");
		echo ("<td>" .$unitShortName ."</td>");
		echo ("<td>" .$unitName ."</td>");
		echo "<td><a id=\"unitid_" .$unitId  ."\" alt=\"Edit\" href=\"#\" onClick=\"javascript:updateDialog('Update Company', 'lib/manageunit.php','lib/manageunit.php'," .$unitId .",'updateDetails()')\"><span>Edit Unit</span><div class=\"modify\"></div></a></td>";
		echo "<td><a title='Delete Unit' id=\"companyid_" .$unitId  ."\" href=\"#\"  onClick=\"javascript:deleteDialog('Delete Company', 'lib/manageunit.php','lib/manageunit.php'," .$unitId .",'updateDetails()')\"><span>Remove Unit</span><div class=\"delete\"></div></a></td>";
		echo ("</tr>");

	}
} else{
		echo ("<tr>");
		echo ("<td colspan=\"5\">Please select <b>company/unit</b> first</td>");
}
?>
	</tbody>
</table>
</div>
</div>

</div>
</div>
</div>
<?php
	include("footer.php");
?>