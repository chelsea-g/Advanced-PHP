<?php

	// Start the session
	require_once('scripts/start-session.php');

	// Set title
	$title = "New Account";
	require_once('templates/header.php');

	require_once('CrudyAPI/classes/REsTAdmin.php');

	// Empty errors & success
	$error = array(
				"username" => "",
				"password" => "",
				"repeat_password" => "",
				"account" => ""
			);

	$success = "";

	// Form is submitted
	if (isset($_POST['submit'])) {

		$admin = new REsTAdmin();

		// Strip HTML tags from input (just in case...)
		$_POST['username'] = strip_tags($_POST['username']);

		// Error: Empty username
		if (empty($_POST['username'])) {

			$error['username'] = "Username is required.";

		// Error: Username too short
		} else if (strlen($_POST['username']) < 3) {

			$error['username'] = "Your username must be at least 3 characters long.";

		// Error: Password empty
		} else if (empty($_POST['password'])) {

			$error['password'] = "Password is required.";

		// Error: passwords was not repeated
		} else if (empty($_POST['repeat_password'])) {

			$error['repeat_password'] = "You must repeat your Password.";

		// Error: passwords do not match
		} else if ($_POST['password'] != $_POST['repeat_password']) {

			$error['repeat_password'] = "Your passwords do not match.";

		// Error: Username taken
		} else if ($admin->checkUsernameExists($_POST['username'])) {

			$error['username'] = "That username is already in use.";
			$_POST['username'] = "";

		// Success create the account and offer to login.
		} else {

			$key = $admin->createAccount($_POST['username'], $_POST['password']);

			if (!empty($key)) {

				$success = "Your account for '" . $_POST['username'] . "' has been successfully created!<br />"
						. "Your API Key is: <br />" . $key . "<br /><br /><a href='index.php'>Login</a> to access your account.";

			} else {

				$error['account'] = "There was a problem creating your account.";

			}

		}

	}

	// Don't let a logged in user create another account
	if (isset($_SESSION['username'])) {

		header('Location: index.php');

	// Show the form
	} else if (empty($success) && empty($error['account'])) {

		?>

		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<label for="username">Choose a username: </label><br />
			<input type="text" name="username" value="<?php if (!empty($_POST['username'])) echo $_POST['username'] ?>"/>
			<?php echo $error['username']; ?><br />
			<label for="password">Choose a password: </label><br />
			<input type="password" name="password" />
			<?php echo $error['password']; ?><br />
			<label for="repeat_password">Repeat password: </label><br />
			<input type="password" name="repeat_password"/>
			<?php echo $error['repeat_password']; ?><br /><br />

			<input type="submit" name="submit" value="Create Account" />
		</form>

		<?php


	// Account creation successful
	} else if (!empty($success)) {

		echo $success;


	// Unsuccessful creation
	} else {

		echo $error['account'];

	}

	require_once("templates/footer.php");
?>
