$(document).ready(function() {
	var easyWords = ["FOO", "BARR", "TEST", "MATTSUCKS", "ORNOT"];
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
			+= '<a class="waves-effect waves-light btn-floating disabled move-above"></a>';
		}
		
		// now for the rest of that logic...
		$("div .move-bot").click(function() {
			// just want the text, none of that other bullshit
			var buttonAnswer = $(this).text();
			console.log("your word is: " + splitWord);

			if($.inArray(buttonAnswer, splitWord) != -1) {
				console.log("ITS IN THERE");
				$(this).addClass("disabled");
				
			} else {
				// increment counter disable button and add a miss
				console.log("no lol");
				lettersMissed++;
				console.log("Letters Missed: " + lettersMissed);
				$(this).addClass("disabled");
			}
		});
});