<?php

	require_once('TaskManager.php');

	// Lazily define db variables
	$dns = "mysql:dbname=task_manager;host=localhost";
	$user = "root";
	$pass = "root";

	// Create a new TaskManager
	$taskManager = new TaskManager($dns, $user, $pass);

	// Switch on the Request Method sent by the form
	$httpVerb = $_SERVER['REQUEST_METHOD'];

	switch ($httpVerb) {

		// GET ouput
		case "GET":

			// Read a single task based on the given id and output
			if (!empty($_GET['id'])) {

				$results = $taskManager->read($_GET['id']);

				if (!empty($results)) {

					echo "<h2>The ID of " . $results['id']
							. " is associated with the task \""
							. $results['description'] . "\"</h2>";

				} else {

					echo "ID not in tasks table";

				}


			// Read all the tasks and output them in a nice table
			} else if (!empty($_GET['read_all'])) {

				$results = $taskManager->readAll();

				echo "<table border=\"solid\"><tr><th colspan=\"2\">"
						. "All Tasks</th></tr><tr><th>ID</th><th>"
						. "Description</th></tr>";

				foreach ($results as $task) {

					echo "<tr><td>" . $task['id'] . "</td><td>"
							. $task['description'] . "</td></tr>";

				}

				echo "</table>";

			// The form is missing input
			} else {

				echo "No ID given.";

			}

			break;


		// POST output
		case "POST":

			// Update a task's description based on given id and description
			// Output number of rows affected.
			if (!empty($_POST['up_id']) && !empty($_POST['up_desc'])) {

				$rowsAffected = $taskManager->update($_POST['up_id'], $_POST['up_desc']);
				echo "<h3>Number of rows affected: " . $rowsAffected . "</h3>";

			// Create a task based on given description
			// Output new id of added task
			} else if (!empty($_POST['desc'])) {

				echo "<h2>ID of new task \"" . $_POST['desc'] . "\": "
						. $taskManager->create($_POST['desc']) . "</h2>";

			// Delete a task based on given id
			// Output number of rows affected.
			} else if (!empty($_POST['del_id'])) {

				$rowsAffected = $taskManager->delete($_POST['del_id']);
				echo  "<h3>Number of rows affected: " . $rowsAffected . "</h3>";

			// The form is missing input
			} else {

				echo "ID and/or description not given.";

			}

			break;

		default:

			// Just in case...
			throw new Exception("Something went wrong.");

			break;



	}

	// Link back to the manager
	echo "<br /><a href=\"task-test.html\">Back to Task Manager</a>";


?>
