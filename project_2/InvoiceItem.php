<?php

	class InvoiceItem {


		// Declare instance variables
		private $id;
		private $quantity;
		private $price;
		private $description;


		/**
		 * Calculates the total price of the item
		 * depending on the quantity that was ordered
		 * of this item.
		 *
		 * @return double: the total price for this item
		 */
		public function calculateItemTotal() {

			// Multiply the item's quantity by it's price
			return $this->quantity * $this->price;

		}


		/**
		 * Outputs a table row for the
		 * information about this item
		 */
		public function display() {

			// |id|description|quantity|price|total_price|
			echo "<tr><td>" . $this->getId() . "</td>"
					. "<td>" . $this->getDescription() . "</td>"
					. "<td>" . $this->getQuantity() . "</td>"
					. "<td>$" . $this->getPrice() . "</td>"
					. "<td>$" . $this->calculateItemTotal()
					. "</td></tr>";

		}


		// Getters and Setters
		public function getId() { return $this->id; }

		public function getQuantity() { return $this->quantity; }

		public function getPrice() { return $this->price; }

		public function getDescription() { return $this->description; }

		public function setId($id) { $this->id = $id; }

		public function setQuantity($quantity) { $this->quantity = $quantity; }

		public function setPrice($price) { $this->price = $price; }

		public function setDescription($description) { $this->description = $description; }


	}


?>
