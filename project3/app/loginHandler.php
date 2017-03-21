<?php

// object orient all the things

class loginHandler extends databaseHandler {

	public function login_action() {
		// initiate db connection
		$db = $this->mysqlConnection();

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$user = mysqli_real_escape_string($db, $_POST["username"]);
			$pass = mysqli_real_escape_string($db, $_POST["password"]);

			// comparing the hashes of the text entered vs the ones in the db
			$pass = hash("sha256", $pass);

			// prepared statement for the search of a user
			if($sql = $db->prepare("SELECT username, password FROM tsarbucks.users WHERE username = ? && password = ?")) {
				$sql->bind_param("ss", $user, $pass);
				$sql->execute();
				$sql->bind_result($username, $password);
				
				// if a good username and password is received, log in. else, you're fucked.
				if ($sql->fetch()) {
					// set the sesh var to 0, meaning logged in. 1 for logged out.
					$_SESSION["loggedin"] = 1;
					mysqli_close($db);
				} else {
					// redirect the user back to the login page if username and password are wrong
					header("Location: login.php");
					mysqli_close($db);
				}
			}
		}
	}

	public function logout_action() {
		// unset session variables and destroy sesh
		session_start();
		unset($_SESSION);
		session_destroy();
		session_write_close();
		header('Location: login.php');
		die;
	}

}