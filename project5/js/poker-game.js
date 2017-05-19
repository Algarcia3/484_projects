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

        // call functions for game, card generation, rounds, reveal, etc. 
        generateCards(socket.player, totalPlayers, 5);

        // start off with the first player
        socket.emit("start_round", {player_num: socket.player, total_players: totalPlayers, player_turn: 1, total_rounds: 1});
    });

    socket.on('next_round', function(data) {
    // var total_rounds = 1;
    
        if(socket.player <= data["player_num"]) {
            $("#draw-p" + socket.player).html('<a id="draw_button" class="btn btn-lg active" role="button" aria-pressed="true">Draw</a>');
            $('#poker-table-p' + socket.player).children().on('click', function (e) {
                // toggle, SIP prevents the click being registered as a double click
                e.stopImmediatePropagation();
                if(!$(this).hasClass( "red-bg" )) {
                    $(this).addClass("red-bg");
                } else {
                    $(this).removeClass("red-bg");
                }
            });
        } 

        // set up the event on click
         $("#draw-p" + data["player_num"]).click(function(e) {
             e.stopImmediatePropagation();
            // talk to the server and get response back to start the game.
            $("#draw-p" + data["player_num"]).remove();

            // count the number of items with red backs, aka cards to be removed
            var removeCards = $('#poker-table-p' + socket.player + " .red-bg").length;
            generateCards(socket.player, 0, removeCards);

            // remove the present cards and draw new ones
            $('#poker-table-p' + socket.player + " .red-bg").remove();

            data["player_turn"]++;
            data["player_num"]++;
            console.log("Player Num: " + data["player_num"]);
            console.log("Player Total: " + data["total_players"]);
            if(data["player_num"] <= data["total_players"]) {
                socket.emit("start_round", {player_num: data["player_num"], total_players: data["total_players"], player_turn: data["player_turn"], total_rounds: data["total_rounds"]});
            } else {
                // random number determines winner... srry 
                var p_winner = Math.floor(Math.random() * data["total_players"]) + 1;
                socket.emit("winning_round", {points: 100, winner: p_winner});
            }
        });
    });

    socket.on("winner", function(data) {
        $("#poker-table-p" + data["winner"]).html("WINNER!");
        $("#score-p" + data["winner"]).html('<p>100</p>');
    });

});

/***** all of the poker logic stuff will be handled down here. 
       If I hadn't been a lazy ass, I would have thought this through more and made it OOP. *****/

function generateCards(player_num, playerCounter, amount) {
    // define all of the order and vars
    var card_order = [];
        // card_counter = 0;
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
        for(var i = 0; i < amount; i++) {
            if(card_counter < 52) {
                card_counter++;
                displayCards(card_counter, player_num, playerCounter);
            }
        }
}

// function outputs all of the cards
function displayCards(card_num, player_num, player_count) {
    var i = card_num;
    var count = card_num + 1;
    var card = cards[i];
    console.log(i);
    //  display the cards on the player side.
    $("#poker-table-p" + player_num).append('<span style="font-size: 175%;" id="card-'+count+'" class="label label-info white">'+ card.number + card.suit +'</span> ');
    // display the face down cards for the other players.
    for(var num = 1; num <= player_count; num++) {
        if(num != player_num) {
            $("#poker-table-p" + num).append('<span style="font-size: 175%;" id="card-'+count+'" class="label label-info"><i class="fa fa-glass" aria-hidden="true"></i></span> &nbsp');
        }
    }
}