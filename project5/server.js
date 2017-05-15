// state all of the required packages and dependencies
var app = require('express')();
var express = require('express');
var http = require('http').Server(app);
var io = require('socket.io')(http);
var playerCounter = 0;

// include the path for express to find
app.use("/js", express.static(__dirname + '/js'));
app.use("/img", express.static(__dirname + '/img'));

// define the express routes; I normally have a separate file for this but this application is going to be small in terms of size and stuff

// serve up the page with our HTML, the core of our app.
app.get('/', function(req, res) {
    res.sendFile(__dirname + '/index.html');
});

// start the application on port: 8080
http.listen(8080, function() {
    console.log("Application started on port: 8080");
});


// handle when a player connects and disconnects.
io.sockets.on('connection', function (socket) {

  // define the ID of player. in this case, it's player counter.
  socket.player = playerCounter + 1;
  playerCounter++;
  console.log("Player " + playerCounter + " has joined the game. With an ID of: " + socket.player);
  // only emit the player ID to the respective player. global broadcast means everyone gets the same ID!
  socket.emit('users_count', socket.player);

  // on disconnect, decrement player counter.
  socket.on('disconnect', function () {
    io.sockets.emit("player_disconnected", playerCounter);
    console.log("Player " + playerCounter + " has disconnected from the game.");
    playerCounter--;
  });

  // if the total amount of players is greater than 1, allow game to start
  if(playerCounter > 1) {
    io.sockets.emit("begin_game", playerCounter);
  }

  socket.on("start_game", function(data) {
    io.sockets.emit("initiate_game", playerCounter);
  });
  
});