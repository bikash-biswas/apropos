<?PHP
require_once("lib/user.php"); 
require_once("lib/unit.php"); 
require_once("lib/company.php"); 

?>
<div id="myslidemenu" class="jqueryslidemenu">
	<ul>
		<li><a href="overview.php">Home</a></li>

		
		<li><a href="#">Manage</a>
			<ul>
				<li><a href="#">Group Company</a>
					<ul>
						<li><a href="viewgroupcompany.php">View</a></li>
					</ul>
				</li>
<?PHP
	$canViewAllCompany=$user->isActionAllowed("CAN_VIEW_ALL_COMPANY","GLOBAL");
	if($canViewAllCompany){
?>
				<li><a href="#">Company</a>
					<ul>
						<li><a href="viewcompany.php">View</a></li>
					</ul>
				</li>
<?PHP
	}
?> 
<?PHP
	$canViewUnit=$user->isActionAllowed("CAN_VIEW_UNIT","COMPANY");
	if($canViewUnit){
?>
				<li><a href="#">Unit</a>
					<ul>
						<li><a href="viewunit.php">View</a></li>
					</ul>
				</li>
<?PHP
	}
?> 
<?PHP
	$canViewDocs=$user->isActionAllowed("CAN_VIEW_DOCUMENT","UNIT");
	if($canViewDocs){
?>
				<li><a href="#">Document</a>
					<ul>
						<li><a href="viewdocument.php">View</a></li>
					</ul>
				</li>
<?PHP
	}
?>
<?PHP
	$canViewData=$user->isActionAllowed("CAN_VIEW_DATA","UNIT");
	if($canViewData){
?>	
 				<li><a href="#">Data</a>
					<ul>
						<li><a href="viewdata.php">View</a></li>
					</ul>
				</li>
<?PHP
	}
?>				
<?PHP
	$canViewData=$user->isActionAllowed("CAN_VIEW_DATA","UNIT");
	if($canViewData){
?>	
 				<li><a href="#">User</a>
					<ul>
						<li><a href="viewuser.php">View</a></li>
<?PHP
	$canViewData=$user->isActionAllowed("CAN_VIEW_DATA","UNIT");
	if($canViewData){
?>
						<li><a href="viewuser.php">Assign Role</a></li>

<?PHP
	}
?>
					</ul>
				</li>
<?PHP
	}
?>
		
<?PHP
	$canViewData=$user->isActionAllowed("CAN_VIEW_DATA","UNIT");
	if($canViewData){
?>	
 				<li><a href="#">Role</a>
					<ul>
						<li><a href="viewrole.php">View</a></li>
					</ul>
				</li>
<?PHP
	}
?>				</ul>
		</li>

		
		
		<li><a href="#">Report</a>
			<ul>
				<li><a href="report.php?type=pdf">PDF</a></li>
				<li><a href="report.php?type=html">HTML</a></li>
			</ul>
		</li>

		<li><a href="#">Feedback</a>
			<ul>
				<li><a href="feedback.php">Send Message to Admin</a></li>
				<li><a href="feedback.php">List Messages</a></li>
			</ul>
		</li>
		<li><a href="logout.php">Logout</a></li>
	</ul>

</div>

