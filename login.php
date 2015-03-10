<html>
	<head>
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="pragma" content="no-cache" />
		<link rel="stylesheet" href="css/styles.css">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/compliance.js"></script>
		<link rel="shortcut icon" href="compliance.ico" />
		<title>Please Login</title>
	</head>
	<body>
		<form method="post" action="lib/validate.php">
		<table style="margin: 0 auto;width:20%;" >
			<tr>
				<th colspan=2>
						Login
				</th>
			</tr>
			<tr>
				<td>
						User:
				</td>
				<td>
						<input type="text" name="user" id="user" />
				</td>
			</tr>
			<tr>
				<td>
						Password:
				</td>
				<td>
						<input type="password" name="passwd" id="passwd" />
				</td>
			</tr>

			<tr>
				<td colspan=2 style="text-align: right;">
						<input type="submit" value="Login" name="submit" id="submit" />
				</td>
			</tr> 
		<table>
		</form>
	<body>
</html>