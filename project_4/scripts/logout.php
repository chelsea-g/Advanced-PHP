<?php

	require_once('start-session.php');

	// Loggout if the session is set.
	if (isset($_SESSION['username'])) {

		$_SESSION = array(); // Empty the session vars

		session_destroy(); // Destroy the session

	}

	// Redirect to login page whether the session was originally set or not.
	header('Location: ../index.php');
?>
