 <?php
	include("header.php");
	require_once("lib/managerole.php"); 
?>
<?php
$pageTitle ="View Role List";

$roleManager=new ManageRoles();
$roles=$roleManager->getRoles();
?>
<script type="text/javascript" src="js/company.js"></script>

<script type="text/javascript">
function updateDetails(){
	//Delete all rows except the first row(index 0)
	$("#roledetails > div > div> table > tbody > tr").each(function(index){
		if(index > 0){
			$(this).remove();
		}
	});
	//Get the data from backend
	$.getJSON("lib/managerolehandler.php?fulldetails=yes",function(data,status){
		$.each(data, function(counter, role) {
			
			var roleId=role.id;
			var roleName=role.role;
			var roleDescription=role.description;
 
			var bodyelement=$("#roledetails > div > div> table > tbody");
			var updateStr= '<a id="roleid_'+roleId+ '" href="#" onclick="javascript:updateDialog(\'Update Role\',\'lib/managerolehandler.php\',\'lib/managerolehandler.php\',\''+roleId+'\',\'updateDetails()\')"><span>Edit Role</span><div class="modify"></div></a>';
			var deleteStr= '<a id="roleid_'+roleId+ '" href="#" onclick="javascript:deleteDialog(\'Delete Role\',\'lib/managerolehandler.php\',\'lib/managerolehandler.php\',\''+roleId+'\',\'updateDetails()\')"><span>Remove Role</span><div class="delete"></div></a>';
			var rowString='<tr><td>'+(counter+1) +'</td><td>'+roleName+'</td><td>'+roleDescription+'</td><td>'+updateStr+'</td><td>'+deleteStr+'</td></tr>';
			$(rowString).appendTo(bodyelement);
			
			var pane = $('#roledetails');
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
				View Role
			</td>
		</tr>
	</table>
</div>


<!------- Content ---------->

<div class="scroll-pane displaytable"  id="roledetails">
<table class="contenttable">
	<thead>
		<tr>
			<td style="width:8%">Sl. No.</td>
			<td>Role</td>
			<td style="width:50%">Description</td>
			<td style="width:20px">&nbsp;</td>
			<td style="width:20px">&nbsp;</td>
		</tr>
	</thead>
	
	<tbody>
	<tr>
		<td colspan="5" style="text-align: right;"><a href="#" onClick="javascript:createDialog('Create Role', 'lib/managerolehandler.php','lib/managerolehandler.php','updateDetails()')"><span>Add Role</span><div id="addRole" class="add" style="float:right;"></div> </a></td>
	</tr>
<?php
	$i=1;
	foreach($roles as $role){
		$roleId=$role->getId();
		$roleName=$role->getRole();
		$roleDescription=$role->getDescription();
		
		echo ("<tr>");
		echo ("<td>" .$i ."</td>");
		echo ("<td>" .$roleName ."</td>");
		echo ("<td>" .$roleDescription ."</td>");
		echo "<td><a id=\"roleid_" .$roleId  ."\" alt=\"Edit\" href=\"#\" onClick=\"javascript:updateDialog('Update Role', 'lib/managerolehandler.php','lib/managerole.php'," .$roleId .",'updateDetails()')\"><span>Edit Role</span><div class=\"modify\"></div></a></td>";
		echo "<td><a id=\"roleid_" .$roleId  ."\" href=\"#\"  onClick=\"javascript:deleteDialog('Delete Role', 'lib/managerolehandler.php','lib/managerole.php'," .$roleId .",'updateDetails()')\"><span>Remove Role</span><div class=\"delete\"></div></a></td>";
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