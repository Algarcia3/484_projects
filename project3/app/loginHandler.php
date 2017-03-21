<?php

// object orient all the things

class loginHandler extends databaseHandler {

	public function loginAttempt() {
		$db = $this->mysqlConnection();

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = mysqli_real_escape_string($db, $_POST["username"]);
			$password = mysqli_real_escape_string($db, $_POST["password"]);

			// prepared statement for the search of a user
			if($sql = $db->prepare("SELECT username FROM tsarbucks.users WHERE username = ? && password = ?")) {
				$sql->bind_param("ss", $username, $password);
				$sql->execute();
				
				if(!$sql->errno) {
					trigger_error("GOOD PASS");
				} else {
					trigger_error("BAD PASSS");
				}
			}
			
		}
	}

}