<?php
include "app/databaseHandler.php";
include "app/loginHandler.php";

// hit logout action function which will redirect you back to the login page
$close_conn = new loginHandler();
$close_conn->logout_action();

?>