<?php

// yay custom mysql/db class
// database config file is inside the app/ directory, db_config.php
include "db_config.php";

class databaseHandler {

	public $order_count = 0;
	public $pending_count = 0;

	public function mysql_connection() {
		// connection params for mysql database
		$db_conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		// check if connection was successful
		if(mysqli_connect_errno()) {
			echo "Failed to connect to database: " . mysqli_connect_error();
		} else {
			return $db_conn;
		}
	}

	public function get_all_products() {
		// initiate mysql connection
		$db_conn = $this->mysql_connection();
		$sql = "SELECT product_id, display_name, price, size
		FROM `products`";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			die("There are no products. sry.");
		}

		// throws assoc array of all our values
		while($products = $result->fetch_assoc()) {
			echo '<tr style="font-weight:bold">';
			echo '<td>'.$products["display_name"].'</td>';
			echo '<td>'.$products["price"].'</td>';
			echo '<td>'.$products["size"].'</td>';
			echo '<td>';
			echo '<button name="cart_button" type="submit" value='.$products["product_id"].' type="button" class="btn btn-primary">';
			echo '<i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart';
			echo '</button>';
			echo '</td>';
			echo '</tr>';
		}
	}

	public function get_customer_orders() {
		// DISPLAY ONLY THE CUSTOMERS ORDERS TO THE CUSTOMER
		$db_conn = $this->mysql_connection();
		$sql = "SELECT orders.product_id, orders.order_id, orders.user_id, quantity, completed, display_name, price, size
				FROM orders 
				INNER JOIN products 
				ON orders.product_id = products.product_id
				WHERE orders.user_id = ".$_SESSION["user_id"];

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		// if($result->num_rows == 0) {
		// 	echo "<h1>No Orders Yet</h1>";
		// }

		// retrieve total number of orders
		$order_count = $result->num_rows;

		// throws assoc array of all our values

		if($result->num_rows == 0) {
			echo '<tr style="font-weight:bold">';
			echo "<td><h2>Nothing here. Maybe try <a href='menu.php'>buying something?</a></h2>";
			echo '</tr>';
		} else {
			while($orders = $result->fetch_assoc()) {
				// choose the right status
				$status = '';
				if($orders["completed"] == 1) {
					$status = '<span class="label label-default" style="color:red;">Pending</span>';
				} else {
					$status = '<span class="label label-success" style="color: green;">Complete</span>';
				}

				echo '<tr style="font-weight:bold">';
				echo '<td>'.$orders["display_name"].'</td>';
				echo '<td>'.$orders["price"].'</td>';
				echo '<td>'.$orders["size"].'</td>';
				echo '<td>'.$orders["quantity"].'</td>';
				echo '<td>'.$status.'</td>';
				echo '<td>';
				echo '</td>';
				echo '</tr>';
			}
		}
	}

	public function get_all_orders() {
		// DISPLAY ALL ORDERS FROM ALL CUSTOMERS FOR BARISTA ONLY
		$db_conn = $this->mysql_connection();
		$sql = "SELECT orders.product_id, orders.order_id, orders.user_id, quantity, completed, display_name, price, size
				FROM orders 
				INNER JOIN products 
				ON orders.product_id = products.product_id";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			echo "<h1>No Orders Yet</h1>";
		}

		// retrieve total number of orders
		$order_count = $result->num_rows;

		// throws assoc array of all our values
		while($orders = $result->fetch_assoc()) {
			// choose the right status
			$status = '';
			$button_state = '';
			if($orders["completed"] == 1) {
				$status = '<span class="label label-default" style="color:red;">Pending</span>';
				$button_state = '<button name="cart_button" type="submit" value='.$orders["product_id"].' type="button" class="btn btn-primary">';
			} else {
				$status = '<span class="label label-success" style="color: green;">Complete</span>';
				$button_state = '<button name="cart_button" type="submit" value='.$orders["product_id"].' type="button" class="btn btn-primary" disabled style="background-color: #00452D;">';
			}

			echo '<tr style="font-weight:bold">';
			echo '<td>'.$orders["display_name"].'</td>';
			echo '<td>'.$orders["price"].'</td>';
			echo '<td>'.$orders["size"].'</td>';
			echo '<td>'.$orders["quantity"].'</td>';
			echo '<td>'.$status.'</td>';
			echo '<td>';
			echo $button_state;
			echo '<i class="fa fa-check" aria-hidden="true"></i> Mark As Complete';
			echo '</button>';
			echo '</td>';
			echo '</tr>';
		}
	}

// retarded implementation of count, i know this can be simplified and can be done in a single query call in one of the functions above but im too lazy im sorry
	public function get_order_count() {
		$db_conn = $this->mysql_connection();
		$sql = "SELECT orders.product_id, quantity, completed, display_name, price, size
				FROM orders 
				INNER JOIN products 
				ON orders.product_id = products.product_id";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			$order_count = 0;
		}

		// retrieve total number of orders
		$order_count = $result->num_rows;

		echo $order_count;
	}

	public function get_order_total() {
		$db_conn = $this->mysql_connection();
		$sql = "SELECT orders.product_id, price, quantity
				FROM orders 
				INNER JOIN products 
				ON orders.product_id = products.product_id";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			echo "";
		}

		// retrieve total number of orders
		$order_total = 0;

		// multiply price by quantity
		while($orders = $result->fetch_assoc()) {
			$order_total += $orders["price"] * $orders["quantity"];
		}

		//format to dollar output
		$formatted_num = number_format($order_total, 2, '.', '');
		echo "$" . $formatted_num;
	}

	public function get_order_size() {
		$db_conn = $this->mysql_connection();
		$sql = "SELECT orders.product_id, size, quantity
				FROM orders 
				INNER JOIN products 
				ON orders.product_id = products.product_id";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			echo "";
		}

		// retrieve total number of orders
		$order_size_total = 0;

		// more math for calculating sizes and quantity
		while($orders = $result->fetch_assoc()) {
			$order_size_total += $orders["size"] * $orders["quantity"];
		}

		echo $order_size_total . " Oz.";
	}

	public function complete_order($product_id) {
		// connect to db
		$db_conn = $this->mysql_connection();

		$sql = "UPDATE orders 
				SET completed = 0
				WHERE product_id = $product_id";

		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}
		header("Location: ../pending.php");
	}

	public function count_pending_orders() {
		// connect to db
		$db_conn = $this->mysql_connection();
		$sql = "SELECT completed
				FROM orders
				WHERE completed = 1";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			$pending_count = 0;
		}

		// retrieve total number of orders
		$pending_count = $result->num_rows;

		echo $pending_count;
	}
}