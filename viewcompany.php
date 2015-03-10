 <?php
	include("header.php");
	
	require_once("lib/user.php"); 
	require_once("lib/unit.php"); 
	require_once("lib/company.php"); 

?>
<?php
$pageTitle ="View Company List";

$user= unserialize($_SESSION["user"]);

$companies=$user->getCompanies();
?>
<script type="text/javascript" src="js/company.js"></script>

<script type="text/javascript">
function updateDetails(){
	//Delete all rows except the first row(index 0)
	$("#companydetails > div > div> table > tbody > tr").each(function(index){
		if(index > 0){
			$(this).remove();
		}
	});
	//Get the data from backend
	$.getJSON("lib/managecompany.php?fulldetails=yes",function(data,status){
		$.each(data, function(counter, company) {
			
			var companyId=company.id;
			var companyShortName=company.shortname;
			var companyName=company.companyname;
 
			var bodyelement=$("#companydetails > div > div> table > tbody");
			var updateStr= '<a id="companyid_'+companyId+ '" href="#" onclick="javascript:updateDialog(\'Update Company\',\'lib/managecompany.php\',\'lib/managecompany.php\',\''+companyId+'\',\'updateDetails()\')"><span>Edit Company</span><div class="modify"></div></a>';
			var deleteStr= '<a id="companyid_'+companyId+ '" href="#" onclick="javascript:deleteDialog(\'Delete Company\',\'lib/managecompany.php\',\'lib/managecompany.php\',\''+companyId+'\',\'updateDetails()\')"><span>Remove Company</span><div class="delete"></div></a>';
			var rowString='<tr><td>'+(counter+1) +'</td><td>'+companyShortName+'</td><td>'+companyName+'</td><td>'+updateStr+'</td><td>'+deleteStr+'</td></tr>';
			$(rowString).appendTo(bodyelement);
			
			var pane = $('#companydetails');
			var api = pane.data('jsp');
			api.reinitialise();
		});
	});
}
</script>
<div class="maincontent">
<!------- Header ---------->
<div class="borderedDiv" >
	<table style="width:100%">
		<tr>
			<td class="titleText blueheadertext">
				View Company
			</td>
		</tr>
	</table>
</div>


<!------- Content ---------->

<div class="scroll-pane displaytable"  id="companydetails">
<table class="contenttable">
	<thead>
		<tr>
			<td style="width:8%">Sl. No.</td>
			<td>Company Short Name</td>
			<td style="width:50%">Company</td>
			<td style="width:20px">&nbsp;</td>
			<td style="width:20px">&nbsp;</td>
		</tr>
	</thead>
	
	<tbody>
	<tr>
		<td colspan="5" style="text-align: right;"><a href="#" onClick="javascript:createDialog('Create Company', 'lib/managecompany.php','lib/managecompany.php','updateDetails()')"><span>Add Company</span><div id="addCompany" class="add" style="float:right;"></div> </a></td>
	</tr>
<?php
	$i=1;
	foreach($companies as $company){
		$companyId=$company->getId();
		$companyName=$company->getCompany();
		$companyName=$company->getCompany();
		$companyShortName=$company->getCompanyShort();
		
		echo ("<tr>");
		echo ("<td>" .$i ."</td>");
		echo ("<td>" .$companyShortName ."</td>");
		echo ("<td>" .$companyName ."</td>");
		echo "<td><a id=\"companyid_" .$companyId  ."\" alt=\"Edit\" href=\"#\" onClick=\"javascript:updateDialog('Update Company', 'lib/managecompany.php','lib/managecompany.php'," .$companyId .",'updateDetails()')\"><span>Edit Company</span><div class=\"modify\"></div></a></td>";
		echo "<td><a id=\"companyid_" .$companyId  ."\" href=\"#\"  onClick=\"javascript:deleteDialog('Delete Company', 'lib/managecompany.php','lib/managecompany.php'," .$companyId .",'updateDetails()')\"><span>Remove Company</span><div class=\"delete\"></div></a></td>";
		echo ("</tr>");
		$i++;

	}
?>
	</tbody>
</table>
</div>
</div>
<?php
	include("footer.php");
?>