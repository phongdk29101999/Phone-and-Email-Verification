<?php
    include "core/init.php";

	if (!$userObject->isLoggedIn()) {
        $userObject->redirect("index.php");
    }
    $userId = $_SESSION["user_id"];
    $user = $userObject->userData($userId);

    if (isset($_POST["update"])) {
        $required = array("firstName", "lastName", "username", "email", "password");
        foreach ($_POST as $key => $value) {
            if (empty($value) && in_array($key, $required)) {
                $errors["allFields"] = "All fields are required";
                break;
            }
        }

		if (empty($errors["allFields"])) {
			$firstName = $validate->escape($_POST["firstName"]);
			$lastName = $validate->escape($_POST["lastName"]);
			$username = $validate->escape($_POST["username"]);
			$email = $validate->escape($_POST["email"]);
			$password = $_POST["password"];
	
			if ($validate->length($firstName, 2, 20)) {
				$errors["names"] = "Names can only be between in 2 - 20 characters";
			} else if ($validate->length($lastName, 2, 20)) {
				$errors["names"] = "Names can only be between in 2 - 20 characters";
			}
			if ($validate->length($username, 2, 10)) {
				$errors["username"] = "Username can only be between in 2 - 10 characters";
			} else if ($username != $user->user_name && $userObject->usernameExist($username)) {
				$errors["username"] = "Username is already exist";
			}
			if (!$validate->filterEmail($email)) {
				$errors["email"] = "Invalid email format";
			} else if ($email != $user->email && $userObject->emailExist($email)) {
				$errors["email"] = "Email is already exist";
			} else {
				if (password_verify($password, $user->password)) {
					//update user
					echo $email;
					$userObject->update("users", array("first_name" => $firstName, "last_name" => $lastName, "user_name" => $username, "email" => $email), array("id" => $userId));
					$userObject->redirect("settings.php");
				} else {
					$errors["password"] = "Password is incorrect";
				}
			}
		}
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Update your account</title>
	<link rel="stylesheet" href="assets/css/style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body2">
<div class="home-nav">
	<a href="home.php">Home</a>
</div>
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
			  <form method="POST">
				<div class="name">
				<h3>Change Name</h3>
				<input type="text" name="firstName" placeholder="First Name" value="<?= $validate->escape($user->first_name)?>"/>
				<input type="text" name="lastName" placeholder="Last Name" value="<?= $validate->escape($user->last_name) ?>"/>
				</div>
				<!-- Name Error -->
				<?php if (isset($errors["names"])) :?>
				<span class="error-in"><?= $errors["names"] ?></span>
				<?php endif ?>
				<div>
				<h3>Change User Name</h3>
				<input type="text" name="username" placeholder="UserName" value="<?= $validate->escape($user->user_name) ?>"/>
 				</div>
				<!-- Username Error -->
				<?php if (isset($errors["username"])) :?>
	  		  	<span class="error-in"><?= $errors["username"] ?></span>
				<?php endif ?>
				<div>
				<h3>Change Email</h3>
				<input type="email" name="email" placeholder="Email" value="<?= $validate->escape($user->email) ?>"/>
				<!-- Email Error -->
				<?php if (isset($errors["email"])) :?>
				<span class="error-in"><?= $errors["email"] ?></span>
				<?php endif ?>
				</div>


				<div>
				<h3>Enter your password to update your account</h3>
				<input type="password" name="password" placeholder="Password"/>
				
				<!-- Password Errors -->
				<?php if (isset($errors["password"])) :?>
				<span class="error-in"><?= $errors["password"] ?></span>
				<?php endif ?>
				</div>

				<!-- Required Fields Errors -->
                <?php if (isset($errors["allFields"])) :?>
 				<span class="error-in"><?= $errors["allFields"] ?></span>
                <?php endif ?>
				<div class="btn-div">
				<button value="sign-up" name="update">Save</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>