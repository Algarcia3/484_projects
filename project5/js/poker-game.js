/*
  Where the vast majority of the game logic
  will take place. Will also include socket.io
  interactions.
*/

// declare what host they're connection to. For these purposes, we'll use localhost
var socket = io.connect("localhost:8080");
var playerCounter = 0;

// handle the connections as they are users connect

socket.on('connect', function(){
    // connect the player to their own table.
    socket.on('users_count', function(data){
        socket.player = data;
        var pokerTable = document.getElementById("poker-table");
        console.log("total players client side: " + data);
        console.log("Your ID is: " + socket.player);
    });

    // if user count exceeds 1, start the game.
    socket.on('begin_game', function(data) {
        for(var i = 2; i <= socket.player; i++) {
            var el = document.getElementById("poker-table-p" + i);
            el.innerHTML = data;
        }
    });

    // if the player disconnects, display that they disconnected like a little bitch
    socket.on('player_disconnected', function(data) {
        var player_el = document.getElementById("poker-table-p" + data);
        player_el.innerHTML = "Player disconnected!";
        setTimeout(function() { 
            player_el.innerHTML = "Searching For Player...";
        }, 3000);
    });
});