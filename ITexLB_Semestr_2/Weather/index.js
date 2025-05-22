var express = require("express");
var app = express();

var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('public'));

io.on('connection', function(socket) {
    console.log('Клієнт підключився!');

    let IntervalValue = null;

    socket.on('Start', ({CityVal, IntervalVal}) => {
        console.log(`City: ${CityVal}, interval: ${IntervalVal}`);

        if (IntervalValue) clearInterval(IntervalValue);

        IntervalValue = setInterval(() => {
            var Temp = (Math.random() * 10 + 20).toFixed(0) + ' &deg;С';
            var Rain = (Math.random() * 70).toFixed(0) + ' %';
            var Pressure = (Math.random() * 40 + 750).toFixed(0) + ' мм рт. ст.';
            var Wind = (Math.random() * 15 + 5).toFixed(0) + ' км/г';
            socket.emit('WeatherMonitor', {Temp, Rain, Pressure, Wind});
        }, IntervalVal);
    });

    socket.on('disconnect', () => {
        console.log('Клієнт відключився!');
    });
});

http.listen(3000, function() {
    console.log('listening on *:3000');
});

/*
var express = require("express"); // окрема змінна для зручності
var app = express();

var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('public')); // вказівка каталогу для статичних ресурсів, у якому буде розташовано файл css, що підключається.
app.get('/', function(req, res) {
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
  socket.on('send message', function(msg) {
	io.emit('receive message', msg);
  });
});

http.listen(3000, function() {
  console.log('listening on *:3000');
});*/
