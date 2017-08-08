<?php
	// Start the session
	require_once('scripts/start-session.php');

	// Set title
	$title = "Get New Key";
	require_once('templates/header.php');

	require_once('CrudyAPI/classes/REsTAdmin.php');

	// Make sure only logged in Users can access this page
	if (isset($_SESSION['username']) && $_SESSION['username'] != ADMIN) {

		$admin = new REsTAdmin();
		$success = "";

		// Empty the error
		$key_error = "";

		// New key button was clicked
		if (isset($_POST['submit'])) {

			// Generate a new key for the user
			$new_key = $admin->updateAPIKey($_SESSION['username']);

			// The update was successful if the new key was not returned empty
			if (!empty($new_key)) {

				$success = "Your API key has been successfully updated!<br />"
						. "Your new API Key is: <br />" . $new_key;
			} else {

				$key_error = "There was a problem updating your API Key.";

			}

		}


		// Show the button as long as the key has not just been updated
		if (empty($success) && empty($key_error)) {

			?>

			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				<input type="submit" name="submit" value="Get New API Key" /><br /><br />
			</form>

			<?php

		// Update successful
		} else if (!empty($success)) {

			echo $success;

		// Error updating
		} else {

			echo $key_error;

		}

	// Homepage redirect if the page is inaccessible.
	} else {

		header('Location: index.php');

	}

	require_once('templates/footer.php');

?>
