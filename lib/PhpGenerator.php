<?php
	$servername = "localhost";
	$dbuser = "bikash";
	$dbpasswd = "biswas";
	$dbname = "compliance";
	
	$tableNames=array();
	
	$conn = new mysqli($servername, $dbuser, $dbpasswd, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$generationFolder=$_POST["folderpath"];
			if(!empty($_POST["tables"])){
				$tableList = $_POST["tables"];
				foreach($tableList as $tableName){
					$columnNamesList=array();
					$myfile = fopen(join(DIRECTORY_SEPARATOR,array($generationFolder,strtolower($tableName) .".php")), "w") ;
					fwrite($myfile, "<?php\n");
					fwrite($myfile, "class " .ucfirst(strtolower($tableName)) ." { \n");
					$sql = "SHOW COLUMNS FROM " .$tableName;
					$stmt = $conn->prepare( $sql);
					$stmt->execute();
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						while($row = $result->fetch_array()) {
							array_push($columnNamesList,$row[0]);
						}
					}
					//write the variables
					foreach($columnNamesList as $column){
						fwrite($myfile, "\tprivate \$" .strtolower($column) ." ;\n");
					}
					fwrite($myfile,"\n\n");
					
					//write the methods
					foreach($columnNamesList as $column){
						//Generate getter method
						fwrite($myfile, "\tpublic function get" .ucfirst(strtolower($column)) ."() {\n");
						fwrite($myfile, "\t\treturn \$this->" .strtolower($column) .";\n");
						fwrite($myfile, "\t}\n");
						
						//Generate setter method
						fwrite($myfile, "\tpublic function set" .ucfirst(strtolower($column)) ."(\$" .strtolower($column) .") {\n");
						fwrite($myfile, "\t\t\$this->" .strtolower($column) ."=\$" .strtolower($column) .";\n");
						fwrite($myfile, "\t}\n");
					}
					
					fwrite($myfile,"}\n");
					fwrite($myfile, "?>");
					fclose($myfile);
				}
			 }
		}
		$sql = "SHOW TABLES";
		$stmt = $conn->prepare( $sql);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				array_push($tableNames,$row[0]);
			}
		}
		$conn->close(); 
	}
?>
<html>
	<head>
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="pragma" content="no-cache" />
		<link rel="stylesheet" href="../css/styles.css">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/themes/smoothness/jquery-ui.min.css" />

		<title>Generate Classes</title>
		<script type="text/javascript">
			$(document).ready(function() {
				//$("#dialog").dialog('close'); //Hide the dialog
				$('#selectall').click(function(event) {  //on click
					if(this.checked) { // check select status
						$("[name='tables[]']").each(function() { //loop through each checkbox
							this.checked = true;  //select all checkboxes with class "checkbox1"              
						});
					}else{
						$("[name='tables[]']").each(function() { //loop through each checkbox
							this.checked = false; //deselect all checkboxes with class "checkbox1"                      
						});        
					}
				});
			   
			});
			function createDialog(){
				$("#dialog").dialog();
			}
			
			function confirm(){
				var dynamicDialog = $('<div id="MyDialog"><P>The Old classes will be replaed at target.<br/> Are you sure you want to generate code ?</P></div>');
				dynamicDialog.dialog({ title: "Confirmation required",
                   modal: true,
				   width:'auto',
                   buttons: [
							{ text: "Yes", click: function () {//action code here 
									$(this).dialog("close"); 
									$( "#tableForm" ).submit();
								} 
							 }, 
							 { text: "No", click: function () {
									$(this).dialog("close"); 
								} 
							}
						]
               });
			
			}
	</script>
	
	<style>
	.help_symbol {
		width: 18px;
		height: 18px;
		background: url(../css/images/sprite.png) -90px -126px;
	}
	table tbody tr:nth-child(even) {background: #CCC}
	table tbody tr:nth-child(odd) {background: #FFF}
	</style>
	</head>
	<body>
		<div class="borderedDiv" >
			<table style="width:100%">
				<tr>
					<td class="titleText blueheadertext">
						Generate Classes from DB
					</td>
				</tr>
			</table>
		</div>
		<form method="post" action="PhpBeanGenerator.php" id="tableForm">
		<p>
			<table style="width:30%;margin-left: auto;margin-right: auto;">
				<tr>
					<td>Generation Path</td>
					<td><input type="text" name="folderpath" path="folderpath" value="d:\GeneratedCode" /></td>
					<td><a href="#" onClick="javascript:createDialog()"><div id="help" class="help_symbol" style="float:right;"></div></a></td>					
				</tr>
			</table>			
		</p>
		<p>
			<table style="margin: 0 auto;width:20%;" >
				<thead>
					<tr>
						<td><input type="checkbox" name="selectall" id="selectall" value="" onClick="selectAll()" /></td>
						<td>Table Name</td>
					</tr>
				</thead>
				<tbody>
<?php
		foreach($tableNames as $tableName){
			echo ("<tr>");
			echo ('<td><input type="checkbox" name="tables[]" id="tables[]" value="' .$tableName .'"/></td>');
			echo ('<td>' .$tableName .'</td>');
			echo ("</tr>");
		}
?>
					<tr style="background: #0066cc;">
						<td colspan="2" style="text-align: right;"> <button type="button" onclick="confirm()">Generate Code</button> </td>
					</tr>
				</tbody>
			</table>
			</p>
		</form>
		
		<div id="dialog" title="Generated Class Path::Help" style="display:none;">
			<p>
				Specify the path where the generated classes will be kept.<br/> The folder should be present in the file system. 
			</p>
		</div>
		<div id="dialog" title="Confrm Code generation" style="display:none;">
			<p>
				 
			</p>
		</div>
	</body>
</html>

