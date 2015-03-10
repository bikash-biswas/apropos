<?php
	include("header.php");
	
	require_once("lib/user.php"); 
	require_once("lib/unit.php"); 
	require_once("lib/company.php"); 

?>

<div class="maincontent">
<?php
$pageTitle ="Feedback";
?>

<form method="post" action="feedback.php">
<div style="margin-left:auto;margin-right:auto;width:50%;">
	<table style="height:300px;width:100%">
		<tr><td style="width:15%"><b>Subject:</b></td><td style="width:85%"><input type="text" class="fillfull" name="subject" id="subject"/></td></tr>
		<tr><td style="vertical-align: text-top;"><b>Message:</b></td><td style="height:100%"><textarea name="message" id="message"></textarea></td></tr>
		<tr><td colspan="2" style="text-align: right;"><input type="button" value="Submit" onClick="javascript:sendFeedbackMessage($('#subject').val(), $('#message').val());$('#subject').val('');$('#message').val('')"/></td></tr>
	</table>
</div>
</form>
</div>
<?php
	include("footer.php");
?>