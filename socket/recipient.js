import { io } from 'socket.io-client';

const socket = io('http://localhost:6001');

socket.on('connect', () => {
    console.log(`Connected to server with ID ${socket.id}`);
});

socket.on('connected_users', (data) => {
    console.log(data);
});

socket.on('receive_message', (data) => {
    console.log(data);
});

socket.on('new_chat', (data) => {
    console.log(data);
});

socket.on('disconnect', () => {
    console.log('Disconnected from server');
});
