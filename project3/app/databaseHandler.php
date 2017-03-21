<?php

// yay custom mysql/db class
include "db_config.php";
$db_conn;

class databaseHandler {

	public function mysqlConnection() {
		// connection params for mysql database
		$db_conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		// check if connection was successful
		if(mysqli_connect_errno()) {
			echo "Failed to connect to database: " . mysqli_connect_error();
		} else {
			return $db_conn;
		}
	}

	public function getAllProducts() {
		// initiate mysql connection
		$db_conn = $this->mysqlConnection();
		$sql = "SELECT * FROM `products`";

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
			echo $products['display_name'];
		}
	}
}