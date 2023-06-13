import { createServer } from 'http';
import { Server } from 'socket.io';
import { insertObject } from './opperations/mongo.js';
const httpServer = createServer();
const io = new Server(httpServer, {cors: {origin: '*'}});

io.on('connection', (socket) => {
    const data = socket.handshake.query;
    let userId = parseInt(data['user_id']);
    let tenant = data['tenant'];
    newMessage(socket, tenant);
    newUser(socket, userId);
    socketUsersOnline(socket);
    console.log(socket.id);
    console.log(`Client connected with ID ${socket.id}`);
    socket.on('disconnect', () => {
        console.log(`Client disconnected with ID ${socket.id}`);
        console.log(data);
        disconnectUser(socket, userId);
    });
});

function disconnectUser(socket, userId)
{
    onlineUsers = onlineUsers.filter((value) => value !== userId);
    userIds = userIds.filter((value) => value !== userId);
    emitUsersOnline();
}

function emitUsersOnline()
{
    io.emit('get_users_online', {
        'online_users': onlineUsers
    });
}

function newUser(socket, userId)
{
    userIds[userId] = socket.id;
    if (! onlineUsers.includes(userId)){
        onlineUsers.push(userId);
    }
    emitUsersOnline();
}

function socketUsersOnline(socket)
{
    socket.on('get_users_online', (data) => {
        emitUsersOnline();
    });
}

let onlineUsers = [];
let userIds = [];
async function newMessage(socket, tenant)
{
    socket.on('new_message', (data) => {
        console.log(data);
        io.to([userIds[data.receipt_id.toString()], userIds[data.sender_id.toString()]]).emit('new_message', data);
        const currentDate = new Date();
        insertObject(tenant + '-mongodb', 'chat_messages', {
            sender_id: data['sender_id'], receipt_id: data['receipt_id'], created_at: new Date(currentDate.toISOString()), text: data['text']
        }).then(() => {
            console.log(`Received message from client ${socket.id}: new_chat`);
        });
    });
}

const PORT = 2000;

httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});


