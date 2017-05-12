// state all of the required packages and dependencies
var app = require('express')();
var express = require('express');
var http = require('http').Server(app);
var io = require('socket.io')(http);
var playerCounter = 0;

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

// start up the necessary socket io items. necessary server side calculations will go here.

io.on('connection', function(socket) {

// increment the counter whenever a player joins a game.
    playerCounter++;
    socket.emit("totalPlayerCount", playerCounter);
    console.log("Player " + playerCounter + " has joined the game. (S)");
    socket.on("disconnect", function() {
        console.log("Player " + playerCounter + " has disconnected from the game. (S)");
        playerCounter--;
    });
});