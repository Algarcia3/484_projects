<?php

include "../app/databaseHandler.php";
include "../app/loginHandler.php";
include "../app/Cart.php";

session_start();

$cart = new Cart();
$cart->add_to_cart($_GET["cart_button"]);

?>