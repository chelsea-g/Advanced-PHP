<?php
	require_once('../classes/TaskManager.php');
	require_once('../classes/REsTAdmin.php');

	$taskManager = new TaskManager();
	$admin = new REsTAdmin();

	// Get the request method
	$httpVerb = $_SERVER['REQUEST_METHOD'];


	// Switch on the request method
	switch ($httpVerb) {

		// CREATE
		case "POST":

			// Verify the API key sent
			if (isset($_POST['api_key']) && $admin->validateAPIKey($_POST['api_key'])) {

				// Create a new task
	            if (isset($_POST['desc'])) {

	                echo $taskManager->create($_POST['desc']);

					// Update the user log totals
					if (!$admin->updateUserLog("create", $_POST['api_key'])) {

						throw new Exception("There was an issue updating the user log.");

					}

	            } else {
	                throw new Exception("Invalid HTTP POST request parameters.");
	            }

			} else {

				throw new Exception("Invalid API Key.");

			}

			break;

		// READ
        case "GET":

			// Output as json
			header("Content-Type: application/json");

			// Verify the API key sent
            if (isset($_GET['api_key']) && $admin->validateAPIKey($_GET['api_key'])) {

				// Read by id
				if (isset($_GET['id'])) {

					echo $taskManager->read($_GET['id']);

					// Update the user log totals
					if (!$admin->updateUserLog("read", $_GET['api_key'])) {

						throw new Exception("There was an issue updating the user log.");

					}


				// Read all
				} else {

					echo $taskManager->readAll();

					// Update the user log totals
					if (!$admin->updateUserLog("readAll", $_GET['api_key'])) {

						throw new Exception("There was an issue updating the user log.");

					}

				}

			} else {

				throw new Exception("Invalid API Key.");

			}

			break;

		// UPDATE
        case "PUT":

			// Retrieve the PUT vars
            parse_str(file_get_contents("php://input"), $putVars);

			// Verify the API key sent
            if (isset($putVars['api_key']) && $admin->validateAPIKey($putVars['api_key'])) {

				// Require the id and description as request params & update the task
				if (isset($putVars['id']) && isset($putVars['desc'])) {

					echo $taskManager->update($putVars['id'], $putVars['desc']);

					// Update the user log totals
					if (!$admin->updateUserLog("update", $putVars['api_key'])) {

						throw new Exception("There was an issue updating the user log.");

					}

				} else {

					throw new Exception("Invalid HTTP PUT request parameters.");

				}

			} else {

				throw new Exception("Invalid API Key.");

			}

            break;


		// DELETE
        case "DELETE":

			//Retrieve the DELETE vars
            parse_str(file_get_contents("php://input"), $deleteVars);

			// Verify the API key sent
            if (isset($deleteVars['api_key']) && $admin->validateAPIKey($deleteVars['api_key'])) {

				// Require the id as request param & delete the task
				if (isset($deleteVars['id'])) {

					echo $taskManager->delete($deleteVars['id']);

					// Update the user log totals
					if (!$admin->updateUserLog("delete", $deleteVars['api_key'])) {

						throw new Exception("There was an issue updating the user log.");

					}

				} else {

					throw new Exception("Invalid HTTP DELETE request parameters.");

				}

			} else {

				throw new Exception("Invalid API Key.");

			}

            break;

		// BAD REQUEST
        default:

            throw new Exception("Unsupported HTTP request.");
            break;

	}


?>
