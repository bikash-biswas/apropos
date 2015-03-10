  <?php
	require_once("lib/user.php"); 
	require_once("lib/unit.php"); 
	require_once("lib/company.php"); 
	require_once("dompdf/dompdf_config.inc.php");

	$user= unserialize($_SESSION["user"]);
	
	$unit=$user->getActiveUnit();
	$company=$user->getActiveCompany();
	if(($unit!=null) && ($company !=null)){

	
	$unitId= $unit->getId();
	$companyId= $company->getId();
	$unitName = $unit->getUnit();
	$companyName = $company->getCompany();

	date_default_timezone_set ("Asia/Dili");

	$dateString =date("Y/m/d");

	if($reportType== "pdf"){
		
	$htmlstring .= <<<EOT
		<!DOCTYPE html>
	   <html>
		<head>
			<meta charset="utf-8" />
			<link rel="stylesheet" type="text/css" href="css/styles.css" />
		</head>		
		<body>
EOT;
	}
	$htmlstring .='<p style="margin-top: 1.2cm;">';
	$htmlstring .= '<div class="headerText">Period</div>';
	$htmlstring .= "<div class=\"headerText\">Uploaded On : " . $dateString ."</div>";
	$htmlstring .= "<div class=\"headerText\">Company : " .$companyName .", Unit : " .$unitName ."</div>";


$htmlstring .= <<<EOT

				<div class="reporttable">
				<table width="100%">
					<thead>
					<tr>
						<td>Sl. No.</td>
						<td>Stautory</td>
						<td>Return/Challan etc.</td>
						<td>Period</td>
						<td>Due Date</td>
						<td>Submission/ Updation Date</td>
						<td>Documents Status (With us)</td>
						<td>Remarks</td>
						<td>Size</td>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>1</td>
						<td>Contract Labour (R & A) Act, 1970</td>
						<td>Registration Certificate</td>
						<td>When Required</td>
						<td>-</td>
						<td></td>
						<td>Original</td>
						<td>Duplicate issued by Labour Deptt.</td>
						<td>1KB</td>
					</tr>
					</tbody>
				</table>
				</div>
				</p>
EOT;
	if($reportType== "pdf"){
		$htmlstring .= <<<EOT
			</body>
			</html>
EOT;
	}
	if($reportType=="html"){
		echo $htmlstring;
	}else if($reportType=="pdf"){
		$dompdf = new DOMPDF();
		$dompdf->load_html($htmlstring);
		$dompdf->render();
		$dompdf->stream( $companyName ."_" .$unitName ."_"  .$dateString .".pdf");
	}
}
?>