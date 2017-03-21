<?php
include "app/databaseHandler.php";
include "app/loginHandler.php";

$close_conn = new loginHandler();
$close_conn->logout_action();

?>