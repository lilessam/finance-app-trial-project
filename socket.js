
var server = require('http').Server();
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('*')
redis.on('pmessage', function(pattern, channel, message) {
    message = JSON.parse(message);
    console.log(channel + ':' + message.event)
    io.emit(channel + ':' + message.event, message.data);
})
redis.on('error', err => {
    console.log(err)
});

server.listen(3000);
