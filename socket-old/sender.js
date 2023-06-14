import { io } from 'socket.io-client';

const socket = io('http://localhost:6001');

const messageInterval = setInterval(() => {
    const message = `Hello from client with ID ${socket.id}`;
    console.log(`Sending message: ${message}`);
    let chat_id = Math.floor(Math.random() * 3);
    console.log('chat ID = ' + chat_id);
    // socket.emit('receive_message', {
    //     sender_id: Math.floor(Math.random() * 11),
    //     chat_id: chat_id,
    //     text: 'text'
    // });
    socket.emit('news', {
        sender_id: Math.floor(Math.random() * 11),
        chat_id: chat_id,
        text: 'text'
    });
}, 3000);

socket.on('connect', () => {
    console.log(`Connected to server with ID ${socket.id}`);
});

socket.on('disconnect', () => {
    console.log('Disconnected from server');
    clearInterval(messageInterval);
});
