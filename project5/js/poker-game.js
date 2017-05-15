/*
  Where the vast majority of the game logic
  will take place. Will also include socket.io
  interactions.
*/

// declare what host they're connection to. For these purposes, we'll use localhost
var socket = io.connect("localhost:8080");

// these are the variables for our cards, in their orders. not worrying about jokers
var card_suits = ["S","H","C","D"];
var card_numbers = ["A","2","3","4","5","6","7","8","9","10","J","Q","K"];
var cards = [];
var card_counter = 0;


/***** all of the socket IO stuff will be handled up here. *****/

socket.on('connect', function(){
    // connect the player to their own table.
    socket.on('users_count', function(data){
        socket.player = data;
        var pokerTable = document.getElementById("poker-table");

        // fuck it. anyone can start the game. i dont care anymore
        document.getElementById("start_game").innerHTML = '<a id="ready_button" href="#" class="btn btn-danger btn-lg disabled" role="button" aria-pressed="true">Not Enough Players</a>';
        console.log("total players client side: " + data);
        console.log("Your ID is: " + socket.player);
    });

    // if user count exceeds 1, start the game.
    socket.on('begin_game', function(playerCounter) {
        for(var i = 2; i <= playerCounter; i++) {
            var el = document.getElementById("poker-table-p" + i);
            el.innerHTML = "<div style='color:green;'>Player Ready</div>";
        }
        
        // if player one, change the button to allow game to start.
        document.getElementById("start_game").innerHTML = '<a id="ready_button" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Start Game</a>';
        $("#ready_button").click(function() {
            // talk to the server and get response back to start the game.
            socket.emit("start_game", "Game is now starting.");
        });
    });

    // if the player disconnects, display that they disconnected like a little bitch
    socket.on('player_disconnected', function(playerNumber) {
        var player_el = document.getElementById("poker-table-p" + playerNumber);
        player_el.innerHTML = "<div style='color:red;'>Player disconnected!</div>";

        // enable the button if there is only one player in the lobby.
        if(playerNumber - 1 < 2) {
            console.log(playerNumber);
            document.getElementById("start_game").innerHTML = '<a id="ready_button" class="btn btn-danger btn-lg disabled" role="button" aria-pressed="true">Not Enough Players</a>';
        }
        
        // show the searching for player prompt 3 secs after player disconnects
        setTimeout(function() { 
            player_el.innerHTML = "Searching For Player...";
        }, 3000);
    });

    // when the game actually begins
    socket.on('initiate_game', function(totalPlayers) {
        // start the game here... show the deck of cards and all that shit
        $("#ready_button").remove();

        // remove all of the player tables that were not connected
        for(var i = 4; i > totalPlayers; i--) {
            $("#p" + i).remove();
        }
        
        // clear the tables of the "player ready" text
        for(var i = 0; i <= totalPlayers; i++) {
            $("#poker-table-p" + i).html("");
        }
        generateCards(socket.player);
    });
});

/***** all of the poker logic stuff will be handled down here. *****/

function generateCards(player_num) {
    // define all of the order and vars
    var card_order = [];
        card_counter = 0;
        cards = [];

        // generate all of the suits
        for(suits in card_suits) {
            var c_suit = card_suits[suits];

            // generate all of the numbers
            for(numbers in card_numbers) {
                var c_nums = card_numbers[numbers];
                var card = {
                    suit: c_suit,
                    number: c_nums,
                    // making sure that we are not exceeding 52 cards, not worrying about jokers.
                    order: Math.floor(Math.random() * 5200) + 1
                };
                // push the card after we've gotten its suit and its number...
                cards.push(card);
            }
        }
        // 
        cards = cards.sort(function(a,b) {
            return (a.order < b.order ? -1 : 1)
        });

        // actually display the cards, over to the user.
        for(var i = 0; i < 5; i++) {
            card_counter++;
            displayCards(i, player_num);
        }
        // select a card from the deck, make sure they're getting 52 cards!!!!
            // if(count < 52) {
            //     // display cards to that specific player.
            //     displayCards(count, player_num);
            //     count++;
            // }
            // return false;
}

// function outputs all of the cards
function displayCards(card_num, player_num) {
    var i = card_num
    var count = card_num + 1;
    var card = cards[i];
 	// $("#poker-table-p" + player_num).append(count + " - " + card.number + card.suit + "<br/>"); 
    $("#poker-table-p" + player_num).append('<span style="font-size: 175%;" id="card-'+count+'" class="label label-info">'+ card.number + card.suit +'</span> &nbsp');
}