var express = require('express');
var socket = require('socket.io');

var application = express();
var server = application.listen(5000, function () {
	console.log('Your Server Is runing at http://localhost:5000');
});

application.use(express.static('public_html'));

var sio = socket(server);
var users = [];
var online_users = [];

sio.on('connection', function (visitor) {
	ioConfig(visitor);


	//console.log('we have a new visitor as query=>', visitor.handshake.query);
	/*console.log('we have a new visitor as id=>', visitor);
	visitor['id'] = visitor.handshake.query.user_id;
	console.log('we have a new visitor as id=>', visitor.id);*/
	//console.log('we have a new visitor as =>', visitor.id);
	console.log('we have a new myfriends as =>', visitor['myfriends']);

	//sio.sockets.emit('login', visitor.id);

	visitor.on('message', function (response) {
		//sio.sockets.emit('new_msg', response);

		//users[visitor.id].emit('new_msg', response);
		//users[response.data.receiver_id].emit('new_msg', response);

		//visitor.broadcast.to(3).emit('new_msg', response);
		visitor.broadcast.to(response.data.receiver_id).emit('new_msg', response);
		visitor.emit('new_msg', response);

		//sio.to(visitor.id).emit('new_msg', response);
		//sio.to(response.data.receiver_id).emit('new_msg', response);

		//sio.sockets.connected[visitor.id].emit('new_msg', response);
		//sio.sockets.connected[response.data.receiver_id].emit('new_msg', response);
	});


	visitor.on('readChat', function (response) {
		visitor.emit('readChat', response);
		sio.to(response.receiver_id).emit('readChat', response);
	});

	visitor.on('typingChaton', function (response) {
		sio.to(response.receiver_id).emit('typingChaton', response);
	});
	visitor.on('typingChatoff', function (response) {
		sio.to(response.receiver_id).emit('typingChatoff', response);
	});


	visitor.on('logout', function () {

		var myfriends = visitor['myfriends'];
		for (var id in myfriends) {
			if (index = online_users.indexOf(id) != -1) {
				visitor.broadcast.to(id).emit('logout', visitor.id);
			}

		}
		// remove saved socket from users object
		delete users[visitor.id];
		delete online_users[index];

	});






});





function ioConfig(visitor) {
	sio.use((visitor, next) => {
		visitor['id'] = visitor.handshake.query.user_id;
		visitor.id = visitor.handshake.query.user_id;
		if (visitor.handshake.query.myfriends != '' || visitor.handshake.query.myfriends !== 'undefined') {
			visitor['myfriends'] = visitor.handshake.query.myfriends.replace("[", '').replace("]", '').split(',');
		} else {
			visitor['myfriends'] = [];
		}
		next();
	});
	new_login_sockets(visitor);
	online_users = Object.keys(sio.sockets.sockets);
	users[visitor.id] = visitor;
	isActive(visitor);
	areActive(visitor);


};
function new_login_sockets(visitor) {
	//console.log('obj ', online_users.indexOf(visitor.id));

	if (index = online_users.indexOf(visitor.id) != -1) {
		console.log('old log in ', visitor.id);
	} else {
		console.log('new log in', visitor.id);
		//visitor.broadcast.emit('login', visitor.id);
		var myfriends = visitor['myfriends'];
		for (var id in myfriends) {
			if (index = online_users.indexOf(id) != -1) {
				visitor.broadcast.to(id).emit('login', visitor.id);
			}

		}
	}
};


function isActive(visitor) {
	var myfriends = visitor['myfriends'];
	for (var id in myfriends) {
		if (index = online_users.indexOf(id) != -1) {
			visitor.broadcast.to(id).emit('isActive', visitor.id);
		}

	}
}

function areActive(visitor) {
	var myfriends = visitor['myfriends'];
	var ids = [];
	for (var id in myfriends) {
		if (index = online_users.indexOf(id) != -1) {
			ids.push(id);
		}
	}
	visitor.emit('areActive', ids);
}
