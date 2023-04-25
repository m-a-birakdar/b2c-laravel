import { io } from 'socket.io-client';

const socket = io('http://localhost:6001');

const messageInterval = setInterval(() => {
    const message = `Hello from client with ID ${socket.id}`;
    console.log(`Sending message: ${message}`);
    // socket.emit('start_connection', {
    //     user_id: 123
    // });
}, 5000);

socket.on('connect', () => {
    console.log(`Connected to server with ID ${socket.id}`);
});

socket.on('disconnect', () => {
    console.log('Disconnected from server');
    clearInterval(messageInterval);
});
