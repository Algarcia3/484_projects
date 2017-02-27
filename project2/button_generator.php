<?php

/*too fuckin lazy to write the buttons in the alphabet by hand*/

$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 

$charArray = str_split($alphabet);

foreach($charArray as $chars) {
	// woo all the buttons
	echo '<a class="center waves-effect waves-light btn-floating">' . $chars . '</a>' . "\n";
}

?>