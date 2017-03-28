<?php

include "../app/databaseHandler.php";
include "../app/loginHandler.php";
include "../app/Cart.php";

session_start();

$db = new databaseHandler();
$db->complete_order($_GET["cart_button"]);