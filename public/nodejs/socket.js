var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var TMClient = require('textmagic-rest-client');
var c = new TMClient('jessicaandjani', 'liiRdFw7tjGYydQu82sPE7i0WG95L0');

redis.subscribe('antrian', function(err, count) {

});
redis.subscribe('periksa', function(err, count) {

});
redis.subscribe('rujukan', function(err, count) {
	
});
redis.subscribe('sms', function(err, count) {

});

http.listen(80, function() {
    console.log('Listening on Port 80');
    redis.on('message', function(channel, message) {
	    console.log('Message Received: ' + message);
	    message = JSON.parse(message);
	    if (message.kategori_antrian)
	    	io.emit('antrianFrontOffice'+message.kategori_antrian, message);
	    else
		    io.emit('antrianLayanan'+message.nama_layanan, message);

      if (message.no_pegawai != null)
				io.emit(message.no_pegawai, message);

			if (message.rujukan)
				io.emit(message.nama_poli, message);

   	  if (message.text) {
   	  	c.Messages.send({text: message.text, phones: message.sender_phone}, function(err, res){
		    console.log('Messages.send()', err, res);
		});
   	  } 
	});
});

redis.on('error', function (error) {
  console.dir(error)
})
