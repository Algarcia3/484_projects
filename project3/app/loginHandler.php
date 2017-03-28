<?php

// object orient all the things
/*DISCLAIMER
just focusing on ONE user for this project... customer user.
I'm not considering other users with user ids, etc.
ok maybe I am, i just realized I might have unintentionally added SOME
support for other users. fuck
*/

class loginHandler extends databaseHandler {

	public function login_action() {
		// initiate db connection
		$db = $this->mysql_connection();

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$user = mysqli_real_escape_string($db, $_POST["username"]);
			$pass = mysqli_real_escape_string($db, $_POST["password"]);

			// meh. good enough for government work
			$pass = hash("sha256", $pass);

			// prepared statement for the search of a user
			if($sql = $db->prepare("SELECT users.user_id, users.username, users.password, user_roles.role 
									FROM users LEFT JOIN user_roles 
									ON users.user_id = user_roles.user_id
									WHERE username = ? AND password = ?;")) {
				$sql->bind_param("ss", $user, $pass);
				$sql->execute();
				$sql->bind_result($user_id, $username, $password, $role);
				
				// if a good username and password is received, log in. else, you're fucked.
				if ($sql->fetch()) {
					// set the sesh var to 0, meaning logged in. 1 for logged out.
					$_SESSION["loggedin"] = 1;
					$_SESSION["username"] = $user;
					$_SESSION["user_id"] = $user_id;
					$_SESSION["role"] = $role;
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
		header('Location: ../login.php');
		die;
	}

}