<?php

/*too fuckin lazy to print out all of the buttons*/

$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 

$charArray = str_split($alphabet);

foreach($charArray as $chars) {
	// woo all the buttons
	echo '<a class="center waves-effect waves-light btn-floating">' . $chars . '</a>' . "\n";
}