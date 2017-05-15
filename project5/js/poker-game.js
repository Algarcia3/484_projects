/*
  Where the vast majority of the game logic
  will take place. Will also include socket.io
  interactions.
*/

// declare what host they're connection to. For these purposes, we'll use localhost
var socket = io.connect("localhost:8080");
var countdown;
var timer = 5;

// handle the connections as they are users connect

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
            $('start_game').html('<a id="ready_button" class="btn btn-danger btn-lg disabled" role="button" aria-pressed="true">Not Enough Players</a>');
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
            $("#poker-table-p" + i).empty();
        }
    });
});