import { insertObject } from "./opperations/mongo.js";
import { onlineUsers } from "./main.js";

export function Chat(io, socket, tenant)
{
    newUser(socket);
    newMessage(socket, tenant);
    socketUsersOnline(socket);

    socket.on('disconnect', () => {
        console.log(`Client disconnected with ID ${socket.id}`);
        disconnectUser(socket);
    });

    function disconnectUser(socket)
    {
        const data = socket.handshake.query;
        let userId = parseInt(data['user_id']);
        const index = onlineUsers.findIndex((value) => value.user_id === userId);
        if (index !== -1) {
            onlineUsers.splice(index, 1);
        }
        emitUsersOnline();
    }

    function emitUsersOnline()
    {
        io.emit('get_users_online', {
            'online_users': onlineUsers
        });
    }

    function newUser(socket)
    {
        const data = socket.handshake.query;
        if ('type' in data && data.type === 'once') {
            console.log("Type is 'once'");
        } else {
            let userId = parseInt(data['user_id']);
            if (! onlineUsers.some(obj => obj.user_id === userId)){
                onlineUsers.push({
                    user_id: userId,
                    socket_id: socket.id,
                    tenant: data['tenant'],
                    city_id: 1 // Todo
                });
            }
            emitUsersOnline();
            console.log(onlineUsers);
        }
    }

    function socketUsersOnline(socket)
    {
        socket.on('get_users_online', (data) => {
            emitUsersOnline();
        });
    }

    function newMessage(socket, tenant)
    {
        socket.on('new_message', (data) => {
            const selected = [data.receipt_id, data.sender_id];
            const socketIds = onlineUsers.filter(obj => selected.includes(obj.user_id)).map(obj => obj.socket_id);
            io.to(socketIds).emit('new_message', data);
            const currentDate = new Date();
            insertObject(tenant + '-mongodb', 'chat_messages', {
                sender_id: data['sender_id'], receipt_id: data['receipt_id'], created_at: new Date(currentDate.toISOString()), text: data['text']
            }).then(() => {
                console.log(`Received message from client ${socket.id}: new_chat`);
            });
        });
    }
}
