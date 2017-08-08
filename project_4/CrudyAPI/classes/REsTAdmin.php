<?php

	require_once(__DIR__. '/../config/connectvars.php');

	class REsTAdmin {

		// Declare PDO variable
		private $db;

		/**
		* When a new REsTAdmin is instantiated, automatically connect to
		* the database.
		*/
		public function __construct() {

			try {

				$this->db = new PDO(DSN, DB_USER, DB_PASSWORD);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1); // Needed to run multiple queries at once.

			} catch (PDOException $ex) {

				echo 'Connection failed: ' . $ex->getMessage();

			}

		}

		/**
		 * Creates an account using the username and password given.
		 * Adds the user to the database and returns the api key generated
		 * for the user.
		 *
		 * @param $username - the username to create account for
		 * @param $password - the password to log into the created account
		 * @return The api key for the new user, null if account creation unsuccessful
		 */
		public function createAccount($username, $password) {

			// Return null if unsuccessful
			$retVal = NULL;

			// Securely hash the password
			$password = password_hash($password, PASSWORD_DEFAULT);

			// Generate an API key for the new user
			$api_key = $this->generateAPIKey();

			$sql = "INSERT INTO " . USER_TABLE . "(username, password, api_key) VALUES(:username, :password, :api_key);" //Add the user to the user table
				 . "INSERT INTO " . USER_LOG_TABLE . "(username) VALUES(:username);"; // Add the user to the user log table with counts started at 0

			try {

				$query = $this->db->prepare($sql);

				$query->execute(array(":username"=>$username,
									  ":password"=>$password,
									  ":api_key"=>$api_key
									 ));

				$rows = $query->rowCount(); //Returns the number of rows affected

				// Return the api key if the account creation was successful
				if ($rows == 1) {

					$retVal = $api_key;

				}

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Checks the database for the given username.
		 *
		 * @param $username - the username to be checked
		 * @return true if the username exists, false if it doesn't
		 */
		public function checkUsernameExists($username) {

			// Return true if the username exists
			$retVal = true;

			$sql = "SELECT COUNT(*) FROM " . USER_TABLE . " WHERE username=:username";

			try {

				$query = $this->db->prepare($sql);

				$query->execute(array(":username"=>$username));

				$rows = $query->fetchColumn(); //Returns the number of rows

				// Return false if the username does not exist
				if ($rows == 0) {

					$retVal = false;

				}

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Validates the password associated with the given username.
		 *
		 * @param $username - the username the password needs to match with
		 * @param $password - the password that needs to be verified with username
		 * @return true if the password is valid, false if the password is invalid
		 */
		public function validatePassword($username, $password) {

			// Return false if the password is invalid
			$retVal = false;

			// Strip user input of HTML tags (not sure if needed here...)
			$password = strip_tags($username);

			$sql = "SELECT password FROM " . USER_TABLE . " WHERE username=:username LIMIT 1";

			try {

				$query = $this->db->prepare($sql);

				$query->execute(array(":username"=>$username));

				$hash = $query->fetchColumn(); //Returns the password for this username

				// Securely validate the password against the hash
				// Return true if the password is valid
				if (password_verify($password, $hash)) {

					$retVal = true;

				}

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Generates a new api key. This does not apply the key to
		 * any specific user. Only generates.
		 *
		 * @return a unique API key
		 */
		private function generateAPIKey() {

			// Generate the unique key... (one of many ways to do this)
			$key = md5(uniqid(rand(), true));

			return $key;

		}

		/**
		 * Updates a given user's API key to a newly generated
		 * API key.
		 *
		 * @param $username - the account to update the key for
		 * @return the new API key if successful, null if unsuccessful
		 */
		public function updateAPIKey($username) {

			// Return null if the update was unsuccessful
			$retVal = NULL;

			// Generate a new api key
			$api_key = $this->generateAPIKey();

			$sql = "UPDATE " . USER_TABLE . " SET api_key=:api_key WHERE username=:username";

			try {

				$query = $this->db->prepare($sql);
				$query->execute(array(":api_key"=>$api_key,
							     	  ":username"=>$username
									 ));

				$rows = $query->rowCount();

				// Return the new API key if update was successful
				if ($rows == 1) {

					$retVal = $api_key;

				}

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Validates that the given API exists.
		 *
		 * @param $api_key - the api key to be verified
		 * @return true if it exists, false if it doesn't exist
		 */
		public function validateAPIKey($api_key) {

			// Return false if the API key is invalid
			$retVal = false;

			$sql = "SELECT COUNT(*) FROM " . USER_TABLE . " WHERE api_key=:api_key";

			try {

				$query = $this->db->prepare($sql);
				$query->execute(array(":api_key"=>$api_key));

				$result = $query->fetchColumn();

				// Return true if the API key is valid
				if ($result == 1) {

					$retVal = true;

				}

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Retrieves the username associated with the given
		 * API key.
		 *
		 * @param $api_key - the api key to match to a username
		 * @return the username associated with the given API key
		 */
		public function getUsernameByAPIKey($api_key) {

			// Return null if the given API key is not associated with a username
			$retVal = NULL;

			$sql = "SELECT username FROM " . USER_TABLE . " WHERE api_key=:api_key";

			try {

				$query = $this->db->prepare($sql);
				$query->execute(array(":api_key"=>$api_key));

				// Return the username associated with the key if it found an associated username
				$retVal = $query->fetchColumn();

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

		/**
		 * Updates the count for each request method sent for a specific
		 * user based on their API key and request method.
		 *
		 * @param $method - the request method sent by the api user
		 * @param $api_key - the api key sent by the api user
		 * @return true if the update was successful, false if it wasn't
		 */
		public function updateUserLog($method, $api_key) {

			// Return false if the update was unsuccessful
			$retVal = false;

			// Retrieve the user associated with the key
			$username = $this->getUsernameByAPIKey($api_key);

			if (!empty($username)) {

				// Switch on the request method sent by the user and add 1 to the count of that method under their account
				switch ($method) {

					case "create":

						$sql = "UPDATE " . USER_LOG_TABLE . " SET `create`=`create`+1 WHERE username=:username";

						break;

					case "read":

						$sql = "UPDATE " . USER_LOG_TABLE . " SET `read`=`read`+1 WHERE username=:username";

						break;

					case "readAll":

						$sql = "UPDATE " . USER_LOG_TABLE . " SET readAll=readAll+1 WHERE username=:username";

						break;

					case "update":

						$sql = "UPDATE " . USER_LOG_TABLE . " SET `update`=`update`+1 WHERE username=:username";

						break;

					case "delete":

						$sql = "UPDATE " . USER_LOG_TABLE . " SET `delete`=`delete`+1 WHERE username=:username";

						break;

					default:

						throw new Exception("Unsupported method type.");

						break;

				}

				try {

					$query = $this->db->prepare($sql);
					$query->execute(array(":username"=>$username));

					$rows = $query->rowCount(); // Returns number of rows affected

					// Return true if the update was successful
					if ($rows == 1) {

						$retVal = true;

					}

				} catch (Exception $ex) {

					echo "{$ex->getMessage()}<br />\n";

				}

			} else {

				throw new Exception("There was an issue retrieving the username.");

			}

			return $retVal;

		}

		/**
		 * Retrieve the current user log of requests sent counts.
		 *
		 * @return the array of request counts & users, null if there was an error
		 */
		public function getUserLog() {

			// Return null if there's an error
			$retVal = NULL;

			$sql = "SELECT * FROM " . USER_LOG_TABLE;

			try {

				$query = $this->db->prepare($sql);
				$query->execute();

				// Return the user log array
				$retVal = $query->fetchAll(PDO::FETCH_ASSOC);

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

	}

?>
