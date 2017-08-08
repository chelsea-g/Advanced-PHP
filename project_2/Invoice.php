<?php

	require_once("InvoiceItem.php");

	class Invoice {

		// Declare instance variables
		private $invoiceItems;
		private $invoiceTotal;


		/**
		 * Calculates the total of this invoice
		 * by adding each item total to the invoice
		 * total.
		 *
		 * @return double: the total of this invoice
		 */
		public function calculateInvoice() {

			// Loop through the array of InvoiceItems and add it's
			// item total to the current invoiceTotal
			foreach ($this->getInvoiceItems() as $invoiceItem) {

				$this->setInvoiceTotal($this->getInvoiceTotal()
						+ $invoiceItem->calculateItemTotal());

			}

			return $this->getInvoiceTotal();

		}


		/**
		 * Outputs all rows of this invoice's
		 * information, including the invoice total.
		 */
		public function displayInvoice() {

			// Create a table to neatly display the invoice data
			echo "<table border=\"solid\" cellpadding=\"5px\"><tr><th>ID</th>"
					. "<th>Description</th><th>Quantity</th><th>Price Per Item</th>"
					. "<th>Item Total</th></tr>";

			// Display each item's details in a table row
			foreach ($this->getInvoiceItems() as $invoiceItem) {

				$invoiceItem->display();

			}

			// |total|invoice_total-------------------|
			echo "<tr><td>Total</td><td colspan=\"4\">$"
					. $this->calculateInvoice()
					. "</td></tr></table>";

		}


		// Getters and Setters
		public function getInvoiceItems() { return $this->invoiceItems; }

		public function getInvoiceTotal() { return $this->invoiceTotal; }

		public function setInvoiceItems($invoiceItems) { $this->invoiceItems = $invoiceItems; }

		public function setInvoiceTotal($invoiceTotal) { $this->invoiceTotal = $invoiceTotal; }


	}

	
?>
