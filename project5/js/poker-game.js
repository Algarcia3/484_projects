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
    socket.emit("Player " + playerCounter + " has connected");
});

socket.on("disconnect", function() {
    playerCounter--;
    socket.emit("Player " + playerCounter + " has disconnected");
})