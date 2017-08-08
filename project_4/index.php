<?php
	//Start the session
	require_once('scripts/start-session.php');

	// Set title
	if (isset($_SESSION['username'])) {

		$title = "Home";

	} else {

		$title = "Login";

	}

	require_once('templates/header.php');

	require_once('CrudyAPI/classes/REsTAdmin.php');

	// Empty the errors
	$error = array(
				"form" => "",
				"username" => "",
				"password" => "",
				"login" => ""
			);


	// The login form is submitted
	if (isset($_POST['submit'])) {

		$admin = new REsTAdmin();

		// Strip HTML tags from the input just in case...
		$_POST['username'] = strip_tags($_POST['username']);

		// Error: username empty
		if (empty($_POST['username'])) {

			$error['username'] = "Username is required.";

		// Error: password empty
		} else if (empty($_POST['password'])) {

			$error['password'] = "Password is required.";

		// Error: username does not exist or password is incorrect
		} else if (!$admin->checkUsernameExists($_POST['username'])
				|| !$admin->validatePassword($_POST['username'], $_POST['password'])) {

			$error['form'] = "Username or Password incorrect.";

		// Success: Username and password match, login the user
		} else if ($admin->validatePassword($_POST['username'], $_POST['password'])) {

			$_SESSION['username'] = $_POST['username'];
			header("Location: index.php");

		// Login error
		} else {

			$login = "There was a problem logging into your account.";

		}

	}


	// If the user is logged in, show them their current login. (This may normally be an elaborate homepage...)
	if (isset($_SESSION['username'])) {

		echo "<h2>You are currently logged in as " . $_SESSION['username'] . ".<br />"
				. "You may <a href='scripts/logout.php'>logout</a> if you wish. </h2>";

	// The user is not logged in, show the form
	} else if (empty($error['login'])) {

		?>

		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<label for="username">Username:</label><br />
			<input type="text" name="username" value="<?php if (!empty($_POST['username'])) echo $_POST['username'] ?>"/>
			<?php echo $error['username']; ?><br />
			<label for="password">Password:</label><br />
			<input type="password" name="password" />
			<?php echo $error['password']; ?><br /><br />

			<input type="submit" name="submit" value="Login" /><br /><br />
			<?php echo $error['form']; ?>
		</form>

		<?php

	// Error logging into the account.	
	} else {

		echo $error['login'];

	}

	require_once("templates/footer.php");

?>
