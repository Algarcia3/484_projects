<?php

// yay custom mysql/db class
include "db_config.php";

class databaseHandler {

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
			echo '<button id = '.$products["product_id"].' type="button" class="btn btn-primary">';
			echo '<i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart';
			echo '</button>';
			echo '</td>';
			echo '</tr>';
		}
	}

	public function get_all_orders() {
		$db_conn = $this->mysql_connection();
		$sql = "SELECT product_id, display_name, price, size
		FROM `orders`";

		// check if the query worked
		if(!$result = $db_conn->query($sql)) {
    		die('There was an error running the query [' . $db_conn->error . ']');
		}

		// edge cases... in case there are no products.
		if($result->num_rows == 0) {
			die("There are no orders. sry.");
		}

		// throws assoc array of all our values
		while($orders = $result->fetch_assoc()) {
			echo '<tr style="font-weight:bold">';
			echo '<td>'.$orders["display_name"].'</td>';
			echo '<td>'.$orders["price"].'</td>';
			echo '<td>'.$orders["size"].'</td>';
			echo '<td>';
			echo '<button id = '.$orders["product_id"].' type="button" class="btn btn-primary">';
			echo '<i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart';
			echo '</button>';
			echo '</td>';
			echo '</tr>';
		}
	}
}