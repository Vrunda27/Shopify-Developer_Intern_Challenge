<?php 

	require('session_create.php');

	if(isset($_SESSION['logged']) && $_SESSION['logged'] == TRUE) {
		if($_SESSION['browser'] == $_SERVER['HTTP_USER_AGENT']) {
        header("Refresh:0; url=ui_list.php");
        die();
      }
	}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <link href="icon.png" rel="icon">
      <title>Shopify Challenge</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>

   <body class="login_body">

   	<div class="content" align="center">
			<h4 class="title_heading">Shopify Challenge</h4><br>
			<h3 style="font-size:40px;color:white">By: Vrunda Patel</h3><br>
		</div>
      <div class="content" align="center">
			<form method="POST" action="Auth.php">
			<table class="login" align="center" bgcolor="#70BBFF" cellpadding="10">
				<tr>
					<th colspan="2"><h2 id="login">Log In!</h2></th>
				</tr>
				<tr>
					<th>Email:</th>
					<td><input type="email" class="login_input" name="email" id="myEmail"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="input" required></td>
				</tr>
				<tr>
					<th>Password:</th>
					<td><input class="login_input" type="password" name="password" minlength="8" maxlength="16"></td>
				</tr>
				<tr>
					<th colspan="2"><input class="button" type="submit" value="Login" name="form_type" style="background-color:#1c18ab;">
				</tr>
				<tr>
					<td id="register">Don't have an account?</td>
					<td id="register"><a href="ui_register.php">Sign Up!</a></td>
				</tr>
			</table>
		</form>
		</div>
      <script type="text/javascript"></script>
   </body>
</html>