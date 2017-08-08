<?php

	require_once('ITaskManager.php');
	require_once('REsTAdmin.php');
	require_once('../config/connectvars.php');

	class TaskManager {

		// Declare the PDO variable
		public $db;


		/**
		* When a new TaskManager is instantiated, automatically connect to
		* the database
		*/
		public function __construct() {

			try {

			    $this->db = new PDO(DSN, DB_USER, DB_PASSWORD);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $ex) {

			    echo 'Connection failed: ' . $ex->getMessage();

			}

		}

		
		/**
		* Add a task to the database
		*
		* @param  $desc    - description of the added task
		* @return $retVal  - the generated id of the created task
		*/
		public function create($desc) {

			$retVal = NULL;

			$sql = "INSERT INTO to_do(description) VALUES(:desc)";

			try {

				$query = $this->db->prepare($sql);

				$query->execute(array(":desc"=>$desc));

				$retVal = $this->db->lastInsertId();

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}


		/**
		* Read a task's row based on the id given
		*
		* @param  $id  	  - id of the task to read
		* @return $retVal - the row of the task (in json)
		*/
		public function read($id) {

			$retVal = NULL;

			$sql = "SELECT * FROM to_do WHERE id=:id";

			try {

				$query = $this->db->prepare($sql);
				$query->execute(array(":id"=>$id));
				$results = $query->fetchAll(PDO::FETCH_ASSOC);

				$retVal = json_encode($results, JSON_PRETTY_PRINT);

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}


		/**
		* Read all tasks in the tasks table
		* @return $retVal - task table's associative array (in json)
		*/
		public function readAll() {

			$retVal = NULL;

			$sql = "SELECT * FROM to_do";

			try {

				$query = $this->db->prepare($sql);
				$query->execute();

				$results = $query->fetchAll(PDO::FETCH_ASSOC);
				$retVal = json_encode($results, JSON_PRETTY_PRINT);

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}


		/**
		* Update a task associated with a given id with the new
		* given description
		*
		* @param  $id  	  - id of the task to read
		* @return $retVal - number of rows affected
		*/
		public function update($id, $newDesc) {

			$retVal = NULL;

			$sql = "UPDATE to_do SET description=:newDesc WHERE id=:id";

			try {

				$query = $this->db->prepare($sql);

				$query->execute(array(":newDesc"=>$newDesc, ":id"=>$id));

				$retVal = $query->rowCount();

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}


		/**
		* Update a task associated with a given id with the new
		* given description
		*
		* @param  $id  	  - id of the task to delete
		* @return $retVal - number of rows affected
		*/
		public function delete($id) {

			$retVal = NULL;

			$sql = "DELETE FROM to_do WHERE id=:id";

			try {

				$query = $this->db->prepare($sql);
				$query->execute(array(":id"=>$id));

				$retVal = $query->rowCount(); // Number of rows affected

			} catch (Exception $ex) {

				echo "{$ex->getMessage()}<br />\n";

			}

			return $retVal;

		}

	}

?>
