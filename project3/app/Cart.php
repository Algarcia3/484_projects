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
			if(!isset($_SESSION["items"][$id]["quantity"])) {
				$_SESSION["items"][$id]["display_name"] = $products["display_name"];
				$_SESSION["items"][$id]["price"] = $products["price"];
				$_SESSION["items"][$id]["size"] = $products["size"];
				$_SESSION["items"][$id]["quantity"] = 1;
			} else {
				$_SESSION["items"][$id]["quantity"]++;
			}
		}
		header('Location: ../menu.php');
	}

	public function get_cart_items() {
		// start the session and get the cart items
		if(!$_SESSION["items"]) {
			echo '<tr style="font-weight:bold">';
			echo "<td><h2>Nothing here. Maybe try buying something?</h2>";
			echo '</tr>';
		} else {
			foreach($_SESSION["items"] as $key => $value) {
				echo '<tr style="font-weight:bold">';
				echo '<td>'.$value["display_name"].'</td>';
				echo '<td>'.$value["price"].'</td>';
				echo '<td>'.$value["size"].'</td>';
				echo '<td>'.$value["quantity"].'</td>';
				echo '<td>';
				echo '<button name="cart_button" type="submit" value='.$key.' type="button" class="btn btn-primary">';
				echo '<i class="fa fa-cart-plus" aria-hidden="true"></i> Remove from Cart';
				echo '</button>';
				echo '</td>';
				echo '</tr>';
			}
		}
	}

	public function get_total_orders() {
		// get the amount for the badge...
		$cart_total = 0;
		if(!isset($_SESSION["items"])) {
			$cart_total = 0;
		} else {
			foreach($_SESSION["items"] as $key => $value) {
				$cart_total += $value["quantity"];
			}
		}
		echo $cart_total;
	}

	public function get_cart_total_cost() {
		(float)$cart_total_cost = 0;
		$cart_total_items = 0;
		if(!isset($_SESSION["items"])) {
			$cart_total_cost = 0;
		} else {
			foreach($_SESSION["items"] as $key => $value) {
				$cart_total_cost += $value["price"] * $value["quantity"];
			}
		}
		
		$formatted_num = number_format($cart_total_cost, 2, '.', '');
		echo "$" . $formatted_num;
	}

	public function get_cart_total_size() {
		(float)$cart_total_size = 0;
		$cart_total_items = 0;
		if(!isset($_SESSION["items"])) {
			$cart_total_size = 0;
		} else {
			foreach($_SESSION["items"] as $key => $value) {
				$cart_total_size += $value["size"] * $value["quantity"];
			}
		}
		
		$formatted_num = number_format($cart_total_size, 2, '.', '');
		echo $formatted_num . " Oz.";
	}

	public function delete_from_cart($id) {
		foreach($_SESSION["items"] as $key => $value) {
			if($id == $key && ($value["quantity"] >= 1)) {
				$_SESSION["items"][$id]["quantity"] = $value["quantity"] - 1;
				if($_SESSION["items"][$id]["quantity"] == 0) {
					unset($_SESSION["items"][$id]);
				}
			} 
		}
		header('Location: ../mycart.php');
	}

	public function submit_order() {
		// start the session to place the items in the cart, stored in session var
		session_start();
		$db_conn = $this->mysql_connection();

		// blow away the current database with orders
		$delete_db = "DELETE FROM orders";

		// populate the database with new orders
		if(!$result = $db_conn->query($delete_db)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}
		
	}
}