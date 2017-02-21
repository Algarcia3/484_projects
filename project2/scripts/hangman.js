$(document).ready(function() {
	var easyWords = ["BRANDON", "ALFREDO", "JONAS", "LOLOLOLOLOLOLOL", "MATT"];
	var lettersMissed = 0;

		// getting random word from array, only from a specific index in a specific range
		var warrLength = easyWords.length;
		var randNum = Math.floor(Math.random() * (warrLength - 0)) + 0;

		// now split the random word and look at the chars
		var randWord = easyWords[randNum];
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
			console.log("your word is: " + splitWord);
			// logic for the 
			if($.inArray(buttonAnswer, splitWord) != -1) {
				$(this).addClass("disabled");
				for(var i = 0; i < splitWord.length; i++) {
					if(buttonAnswer == splitWord[i]) {
							document.getElementById(i).innerHTML += splitWord[i];
					}
				}
			} else {
				// increment counter disable button and add a miss
				lettersMissed++;
				console.log("Letters Missed: " + lettersMissed);
				$(this).addClass("disabled");
				// if the letters missed exceed 7, kill it dawg
				if(lettersMissed == 7) {
					
				}
			}
		});
});