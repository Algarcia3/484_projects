// state all of the required packages and dependencies
var app = require('express')();
var http = require('http').Server(app);

// define the express routes; I normally have a separate file for this but this application is going to be small in terms of size and stuff

// serve up the page with our HTML, the core of our app.
app.get('/', function(req, res) {
    res.sendFile(__dirname + '/index.html');
});

// start the application on port: 8080
http.listen(8080, function() {
    console.log("Application started on port: 8080");
});