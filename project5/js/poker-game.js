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
    socket.on('users_count', function(data){
        var pokerTable = document.getElementById("poker-table");
        console.log("total players client side: " + data);
    });
});