 <?php
	include("header.php");
	require_once("lib/managerole.php"); 

?>
<?php
$pageTitle ="View User List";
$divId="userdetails";
$handlerPage="lib/manageuserhandler.php";

$userManager=new ManageUser();
$users=$userManager->getUser();
?>
<script type="text/javascript">
function updateDetails(){
	var handlerPage="<?PHP echo $handlerPage; ?>";
	var divId="<?PHP echo $divId; ?>";
	
	//Delete all rows except the first row(index 0)
	$("#"+divId+" > div > div> table > tbody > tr").each(function(index){
		if(index > 0){
			$(this).remove();
		}
	});
	//Get the data from backend
	$.getJSON(handlerPage+"?fulldetails=yes",function(data,status){
		$.each(data, function(counter, role) {
			
			var userId=user.id;
			var userFirstName=user.fname;
			var userLastName=user.lname;
 
			var bodyelement=$("#"+divId+" > div > div> table > tbody");
			var updateStr= '<a id="userid_'+userId+ '" href="#" onclick="javascript:updateDialog(\'Update User\',\''+ib/managerolehandler.php+'\',\''+ib/managerolehandler.php+'\',\''+roleId+'\',\'updateDetails()\')"><span>Edit User</span><div class="modify"></div></a>';
			var deleteStr= '<a id="userid_'+userId+ '" href="#" onclick="javascript:deleteDialog(\'Delete User\',\'lib/managerolehandler.php\',\'lib/managerolehandler.php\',\''+roleId+'\',\'updateDetails()\')"><span>Remove Role</span><div class="delete"></div></a>';
			var rowString='<tr><td>'+(counter+1) +'</td><td>'+userFirstName+'</td><td>'+userLastName+'</td><td>'+updateStr+'</td><td>'+deleteStr+'</td></tr>';
			$(rowString).appendTo(bodyelement);
			
			var pane = $('#'+divId+'');
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
				View User
			</td>
		</tr>
	</table>
</div>


<!------- Content ---------->

<div class="scroll-pane displaytable"  id="<?PHP echo $divId;?>">
<table class="contenttable">
	<thead>
		<tr>
			<td style="width:8%">Sl. No.</td>
			<td>User</td>
			<td style="width:50%">First Name</td>
			<td style="width:50%">Last Name</td>
			<td style="width:20px">&nbsp;</td>
			<td style="width:20px">&nbsp;</td>
		</tr>
	</thead>
	
	<tbody>
	<tr>
		<td colspan="5" style="text-align: right;"><a href="#" onClick="javascript:createDialog('Create User', '<?PHP echo $handlerPage;?>','<?PHP echo $handlerPage;?>','updateDetails()')"><span>Add User</span><div id="addUser" class="add" style="float:right;"></div> </a></td>
	</tr>
<?php
	$i=1;
	foreach($users as $user){
		$userId=$user->getId();
		$userFirstName=$user->getFirstName();
		$userLastName=$user->getLastName();
		
		echo ("<tr>");
		echo ("<td>" .$i ."</td>");
		echo ("<td>" .$userFirstName ."</td>");
		echo ("<td>" .$userLastName ."</td>");
		echo "<td><a id=\"userid_" .$userId  ."\" alt=\"Edit\" href=\"#\" onClick=\"javascript:updateDialog('Update User', 'lib/managerolehandler.php','lib/managerolehandler.php'," .$userId .",'updateDetails()')\"><span>Edit User</span><div class=\"modify\"></div></a></td>";
		echo "<td><a id=\"userid_" .$userId  ."\" href=\"#\"  onClick=\"javascript:deleteDialog('Delete User', 'lib/managerolehandler.php','lib/managerolehandler.php'," .$userId .",'updateDetails()')\"><span>Remove User</span><div class=\"delete\"></div></a></td>";
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