<?php
	include "core/init.php";
	if (isset($_POST["login"])) {
		$email = $validate->escape($_POST["email"]);
		$password = $validate->escape($_POST["password"]);
		if(empty($email) or empty($password)) {
			$error = "Enter your email or password to login!";
			return;
		}
		if (! $validate->filterEmail($email)) {
			$error = "Invalid email";
			return;
		}
		if (!$user = $userObject->emailExist($email)) {
			$error = "No account with that email exist";
			return;
		}
		$hash = $user->password;
		if (!password_verify($password, $hash)) {
			$error = "Email or Password is incorrect!";
		}
		$_SESSION["user_id"] = $user->id;
		$userObject->redirect("home.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login and Registration With Email & Mobile Verification</title>
	<link rel="stylesheet" href="assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body class="body">
	<div class="wrapper">
	<div class="wrapper-inner">
		<div class="header-wrapper">
			<h1>Welcome</h1>
			<h3>This is an simple Login and Registration system with Email & Mobile verification</h3>			
		</div><!--HEADER WRAPPER ENDS-->
		<div class="sign-div">
		<div class="sign-in">
			<form method="POST">
			<div class="signIn-inner">
				<div class="input-div">
				<input type="email" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<button type="submit" name="login">Login</button>
				</div>
				<?php if (isset($error)):?>
				<div class="error shake-horizontal"><?= $error?></div>
				<?php endif?>
			</form>
			</div>
		</div>
		<div class="r-pass">
			<a href="account/recovery/">I forget my Password</a>
		</div>
		</div><!--CONTENT WRAPPER ENDS-->
		<div class="footer-wrapper">
			<div class="inner-footer-wrap">
			<div class="sign-up"><button class="sign-up-btn" onclick="location.href='account/settings';" type="submit">Sign Up</button></div>
			</div>
		</div><!--FOOTER WRAPPER ENDS-->
	</div>
	</div><!--WRAPPER ENDS-->
</body>
</html>
