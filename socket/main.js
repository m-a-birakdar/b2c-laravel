import { createServer } from 'http';
import { Server } from 'socket.io';
import { Chat } from "./chat.js";
import { Order } from "./order.js";
const httpServer = createServer();
const io = new Server(httpServer, {cors: {origin: '*'}});

export let onlineUsers = [];

io.on('connection', (socket) => {
    const data = socket.handshake.query;
    console.log(typeof data);
    console.log(`Client connected with ID ${socket.id}`);
    if (data.tenant !== undefined) {
        Chat(io, socket, data['tenant']);
    } else {
        Order(io, socket);
    }
});

const PORT = 2000;

httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});


