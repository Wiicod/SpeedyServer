/**
 * Created by Evaris on 25/03/2016.
 *
 * npm install express redis socket.io --save pour installer les dependances (le dossier etant celui contenant ce fichier)
 * node server.js pour lancer le
 */

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
console.log("Listening.....");
io.on('connection', function (socket) {

    console.log("new client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');

    redisClient.on("message", function(channel, message) {
        console.log("mew message in queue "+ message + "channel");
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });

});