// state all of the required packages and dependencies
var app = require('express')();
var express = require('express');
var http = require('http').Server(app);
var io = require('socket.io')(http);
var playerCounter = 0;
var users = {};

// include the path for express to find
app.use("/js", express.static(__dirname + '/js'));

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
  playerCounter++;
  users[client.id] = playerCounter;
  console.log("Player " + playerCounter + " has joined the game.");
  io.sockets.emit('users_count', playerCounter);
  socket.on('disconnect', function () {
    delete users[client.id];
    console.log("Player " + playerCounter + " has disconnected from the game.");
    playerCounter--;
  });
});