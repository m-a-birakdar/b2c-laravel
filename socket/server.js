import { createServer } from 'http';
import { Server } from 'socket.io';
import { startEndConnection } from './events/start_end_connection.js';
import { chat } from './events/chat.js';

const httpServer = createServer();
const io = new Server(httpServer);

io.on('connection', (socket) => {
    console.log(`Client connected with ID ${socket.id}`);
    startEndConnection(socket);
    chat(socket);
    socket.on('disconnect', () => {
        console.log(`Client disconnected with ID ${socket.id}`);
    });
});

const PORT = 6001;
httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});


