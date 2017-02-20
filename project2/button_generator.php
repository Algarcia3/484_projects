<?php

/*too fuckin lazy to print out all of the buttons*/

$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 

$charArray = str_split($alphabet);

foreach($charArray as $chars) {
	// echo all of the buttons in the alphabet, too fuckin lazy to copy and paste that shit
	echo '<a class="center waves-effect waves-light btn-floating">' . $chars . '</a>' . "\n";
}