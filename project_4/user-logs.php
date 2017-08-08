<?php
	// Start the session
	require_once('scripts/start-session.php');

	// Set title
	$title = "Output Users";
	require_once('templates/header.php');

	require_once('CrudyAPI/classes/REsTAdmin.php');

	// Verify that only the Admin can access this page
	if ($_SESSION['username'] == ADMIN) {

		$admin = new REsTAdmin();

		// Get the current user log array
		$userLog = $admin->getUserLog();

		// Output the user log to the page
		?>
		<table border="solid" cellpadding="3">
			<tr><th>Username</th><th>Create</th><th>Read</th><th>Read All</th><th>Update</th><th>Delete</th></tr>
		<?php

		foreach ($userLog as $user) {

			echo "<tr><td>"
					. $user['username'] . "</td><td>" . $user['create'] . "</td><td>"
					. $user['read'] . "</td><td>" . $user['readAll'] . "</td><td>"
					. $user['update'] . "</td><td>" . $user['delete'] .
				 "</td></tr>";

		}

		?>
		</table>

		<?php

	// Redirect to homepage if the user is not Admin
	} else {

		header('Location: index.php');
		
	}

	require_once('templates/footer.php');

?>
