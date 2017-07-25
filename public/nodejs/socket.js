var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

http.listen(80);
redis.subscribe('antrian', function(err, count) {
});
redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);
    if (message.kategori_antrian === '')
    	io.emit('antrianLayanan', message);
    else
	    io.emit('antrianFrontOffice'+message.kategori_antrian, message);
});
http.listen(6000, function(){
    console.log('Listening on Port 6000');
});
redis.on('error', function (error) {
  console.dir(error)
})