import { createServer } from 'http';
import { Server } from 'socket.io';
import { Chat } from "./chat.js";
import { Order } from "./order.js";
const httpServer = createServer();
const io = new Server(httpServer, {cors: {origin: '*'}});

export let onlineUsers = [];

io.on('connection', (socket) => {
    const data = socket.handshake.query;
    console.log(`Client connected with ID ${socket.id}`);
    const connectedClients = io.sockets.server.engine.clientsCount;
    console.log('Number of connected clients:', connectedClients);
    Chat(io, socket, data['tenant']);
    Order(io, socket, data['user_id'], data['tenant']);
});

const PORT = 2000;

httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});
// io.use((socket, next) => {
//     const auth = socket.request.headers.authorization;
//     const user = socket.request.headers.user;
//     if(auth && user) {
//         const token = auth.replace('Bearer ', '');
//         console.log('auth token', token);
//         // do some security check with token
//         // ...
//         // store token and bind with specific socket id
//         if (!tokens[token] && !users[token]) {
//             tokens[token] = socket.id;
//             users[token] = user;
//         }
//         return next();
//     } else{
//         return next(new Error('no authorization header'));
//     }
// });

