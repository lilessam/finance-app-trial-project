let socket_io_host = document.head.querySelector('meta[name="socket-io-host"]');
window.socket = require('socket.io-client')(socket_io_host.content);
