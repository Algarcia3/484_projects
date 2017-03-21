<?php

// object orient all the things

class loginHandler extends databaseHandler {

	public function loginAttempt() {
		$db = $this->mysqlConnection();

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = mysqli_real_escape_string($db, $_POST["username"]);
			$password = mysqli_real_escape_string($db, $_POST["password"]);
		}
	}

}