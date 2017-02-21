$(document).ready(function() {
	// letters must be in all caps, i don't really care about case sensitivity
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
			+= '<a id='+ i +' class="waves-effect waves-light btn-floating disabled move-above"></a>';
		}
		
		// now for the rest of that logic...
		$("div .move-bot").click(function() {
			// just want the text, none of that other bullshit
			var buttonAnswer = $(this).text();
			/* 
				if the letter is in our word, then disable the button and iterate through placeholders,
				and add in the corresponding letters to the placeholder. 
			*/
			if($.inArray(buttonAnswer, splitWord) != -1) {
				$(this).addClass("disabled");
				for(var i = 0; i < splitWord.length; i++) {
					if(buttonAnswer == splitWord[i]) {
						document.getElementById(i).innerHTML += splitWord[i];
					}
				}

				/* 
					compare lengths of text in placeholders to the actual length of the word; 
					if the amount matches the amount of letters, you win. 
				*/
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
				document.getElementById("miss-counter").innerHTML 
				= "<p class='misses'>Misses: " + lettersMissed + "/7</p>";

				// constructing the hanging man... looks fucking disgusting
				switch(lettersMissed) {
					case 1:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 2:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 3:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||             O
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 4:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||             O
          ||             |
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 5:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||            `+'\\'+`O/
          ||             |
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 6:
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||            `+'\\'+`O/
          ||             |
          ||            /
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
					break;
					case 7:
						// add the last part of the hangman
						document.getElementById("hanging-man").
						innerHTML = `<pre>
          ||--------------
          ||             |
          ||             |
          ||            `+'\\'+`O/
          ||             |
          ||            / `+'\\'+`
          ||
          ||
          ||
          ||
          ||
          ||
          ||
          ===========================
      </pre>`;
						document.getElementById('winorlose').innerHTML
						+= '<a class="move-losetext">You Lose!!!</a>';
						// disable all buttons upon failing
						$('div#hangman-buttons a').addClass('disabled');
						break;
					default:
						// hopefully this never gets triggered lmao
						console.log("error");
				}
			}
		});
});