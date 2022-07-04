<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Verification</title>
	<link rel="stylesheet" href="assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body2">
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
				<div class="name">
				<h4>Your account has been created, you need to activate your account by following methods:</h4>
				<fieldset>
				<legend>Method 1</legend>
				<form method="POST">
				<h3>Email verificaiton</h3>
				<input type="email" name="email" disabled placeholder="User email" value="User email"/>
 				<button type="submit" class="suc">Send me verification email</button>
				</form>
				</fieldset>
				</div>
 				<!-- Email error field -->
				<span class="error-in"><b>Email Field Error</b></span>

				<fieldset>
					<legend>Method 2</legend>
				<div>
					<h3>Phone verificaiton</h3>
					<form method="POST">
					<input type="tel" name="number" placeholder="Enter your Phone number"/>
					<button type="submit" name="phone" class="suc">Send verification code via SMS</button>
					</form>
				</div>
 				</fieldset>
 				<!-- Phone error field -->
				<span class="error-in"><b>Phone Field Error</b></span>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>
