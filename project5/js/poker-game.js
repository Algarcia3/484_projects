/*
  Where the vast majority of the game logic
  will take place. Will also include socket.io
  interactions.
*/

// declare what host they're connection to. For these purposes, we'll use localhost
var socket = io.connect("localhost:8080");
var playerCounter = 0;

// handle the connections as they are users connect

socket.on("connect", function() {
    playerCounter++;
    // console.log("player count client side: " + playerCounter);
    
    socket.emit("Player " + playerCounter + " has connected (C)");
    socket.on("totalPlayerCount", function(totalPlayers) {
        var pokerTable = document.getElementById("poker-table");
        console.log("total players client side: " + totalPlayers);
        pokerTable.innerHTML += `<h2>Player ` + totalPlayers + `</h2>
			<div class="jumbotron text-center">
			</div>`;
    });
});

socket.on("disconnect", function() {
    // decrement the counter when you leave.
    playerCounter--;
});