$(document).ready(function() {
	var allWords = ["BRANDON", "ALFREDO", "JONAS", "LOLOLOLOLOLOLOL", "MATT"];
	var lettersMissed = 0;

		// getting random word from array, from the maximum index of array 
		var arrLen = allWords.length;
		var randNum = Math.floor(Math.random() * (arrLen - 0)) + 0;

		// now split the random word and look at the chars
		var randWord = allWords[randNum];
		var splitWord = randWord.split('');

		// generate the amount of placeholders based on amount of letters
		for(var i = 0; i < splitWord.length; i++) {
			document.getElementById('placeholders').innerHTML 
			+= '<a id='+i+' class="waves-effect waves-light btn-floating disabled move-above"></a>';
		}
		
		// now for the rest of that logic...
		$("div .move-bot").click(function() {
			// just want the text, none of that other bullshit
			var buttonAnswer = $(this).text();
			// logic for whether the guess was right or not
			if($.inArray(buttonAnswer, splitWord) != -1) {
				$(this).addClass("disabled");
				for(var i = 0; i < splitWord.length; i++) {
					if(buttonAnswer == splitWord[i]) {
						document.getElementById(i).innerHTML += splitWord[i];
					}
				}
				// compare lengths of text to placeholders; if the amount matches the amount of letters, you win.
				var ph = $('div#placeholders a').text();
				if (ph.length == splitWord.length) {
					// generate the winning text
					document.getElementById('winorlose').innerHTML
					+= '<a class="move-losetext">You Win!!!</a>';
					// disable the buttons after win
					$('div#hangman-buttons a').addClass('disabled');
				}
			} else {
				// increment counter disable button and add a miss
				lettersMissed++;
				$(this).addClass("disabled");
				document.getElementById("miss-counter").innerHTML = "<p class='misses'>Misses: " + lettersMissed + "/7</p>";
				// if 7 letters were missed, kill it dawg
				if(lettersMissed == 7) {
					document.getElementById('winorlose').innerHTML
					+= '<a class="move-losetext">You Lose!!!</a>';
					// disable all buttons upon failing...
					$('div#hangman-buttons a').addClass('disabled');
				}
			}
		});
});