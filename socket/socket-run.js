var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

app.get('/', function (req, res) {
	res.send('<h1>ARBA SOCKET</h1>');
});

io.on('connection', function(socket){
	console.log('a user connected');
	
	socket.emit('live:connected');
	
	//Trigger ARBA
	socket.on('live:event:trigger', function(event, type, data){
		io.emit('live:event:getting', event, type, data);
		
	});
	
	//Counters
	socket.on('message:new', function (response) {
		if(typeof response === typeof {} && typeof response.user_id != 'undefined'){
			console.warn('message:get:'+response.user_id, response.data);
			io.emit('message:get:'+response.user_id, response.data);
		}
	});
});

server.listen(3000, function(){
	console.log('listening on *:3000');
});