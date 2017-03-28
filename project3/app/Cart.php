<?php

class Cart extends databaseHandler {

	public function add_to_cart($id) {
		// start the session to place the items in the cart, stored in session var
		session_start();

		$db_conn = $this->mysql_connection();
		$sql = "SELECT product_id, display_name, price, size
		FROM `products`
		WHERE product_id = $id";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			die("There are no products. sry.");
		}

		// set session vars to the items there
		while($products = $result->fetch_assoc()) {
			// increase the quantity of items if the quantity is set to 0. if not 0, increment it by one.
			if($_SESSION["item"][$id]["quantity"] == 0) {
				$_SESSION["item"][$id]["display_name"] = $products["display_name"];
				$_SESSION["item"][$id]["price"] = $products["price"];
				$_SESSION["item"][$id]["size"] = $products["size"];
				$_SESSION["item"][$id]["quantity"] = 1;
			} else {
				$_SESSION["item"][$id]["quantity"]++;
			}
		}
		header('Location: ../menu.php');
	}
}