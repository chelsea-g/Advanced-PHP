<?php

	require_once("InvoiceItem.php");
	require_once("Invoice.php");

	class ProcessInvoice {

		// Declare instance variables
		private $invoice; // Array of Invoice Items


		/**
		 * Creates 3 InvoiceItems and places
		 * them in this Invoice's InvoiceItems array.
		 */
		private function createInvoiceItems() {

			// First item
			$hoolaHoop = new InvoiceItem();
			$hoolaHoop->setId(2564);
			$hoolaHoop->setQuantity(3);
			$hoolaHoop->setPrice(11.99);
			$hoolaHoop->setDescription("Hoolahoops");

			// Second item
			$waterBottle = new InvoiceItem();
			$waterBottle->setId(645);
			$waterBottle->setQuantity(5);
			$waterBottle->setPrice(13.45);
			$waterBottle->setDescription("Water Bottles");

			// Third item
			$historyBook = new InvoiceItem();
			$historyBook->setId(3122);
			$historyBook->setQuantity(10);
			$historyBook->setPrice(86.23);
			$historyBook->setDescription("History Books");

			// Set the current InvoiceItems array to an array of the instantiated items
			$this->invoice->setInvoiceItems(array($hoolaHoop, $waterBottle, $historyBook));


		}


		/**
		 * Calls all neccessary methods to
		 * process an invoice completely.
		 */
		public function runProcess() {

			//Instantiate a new invoice
			$this->setInvoice(new Invoice());

			//Load items into the InvoiceItems array
			$this->createInvoiceItems();

			//Output the Invoice's data table
			$this->getInvoice()->displayInvoice();

		}


		// Getters and Setters
		public function getInvoice() { return $this->invoice; }

		public function setInvoice($invoice) { $this->invoice = $invoice; }

		
	}


?>
