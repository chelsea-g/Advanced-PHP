<?php

	require_once("ProcessInvoice.php");

	class InvoiceTestDrive {


		/**
		 * The "main method" for this application.
		 *
		 */
		public function main() {

			// Instantiate ProcessInvoice object
			$processInvoice = new ProcessInvoice();

			// Run Processing
			$processInvoice->runProcess();

		}


	}


	// Run app
	$main = new InvoiceTestDrive();
	$main->main();


?>
