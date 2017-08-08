<!DOCTYPE HTML>
<html>
	<head>

		<title>CRUDY - <?php echo $title ?></title>

	</head>

	<body>

		<?php

			require_once('config/appvars.php');

			// User is logged in
			if (!isset($_SESSION['username'])) {

				?>
				<a href="index.php">Login</a> | <a href="new-account.php">Create Account</a>
				<?php

			// Admin is logged in
			} else if ($_SESSION['username'] == ADMIN) {

				?>
				<a href="index.php">Home</a> | <a href="user-logs.php">User Logs</a> | <a href="scripts/logout.php">Log Out (<?php echo $_SESSION['username'] ?>)</a>
				<?php

			// Not logged in
			} else {

				?>
				<a href="index.php">Home</a> | <a href="get-new-key.php">Get New API Key</a> | <a href="scripts/logout.php">Log Out (<?php echo $_SESSION['username'] ?>)</a><br />
				<?php
				
			}

		?>

		<hr />
		<h1>CRUDY - <?php echo $title ?></h1>
