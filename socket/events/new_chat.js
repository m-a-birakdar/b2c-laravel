import { insertObject } from '../opperations/mongo.js'

export function newChat(io, socket) {
    socket.on('new_chat', (data) => {
        io.emit('new_chat', data);
        insertObject('chats', {
            user1_id: data['user1_id'],
            user2_id: data['user2_id'],
            created_at: new Date(),
        }).then(() => {
            console.log(`Received message from client ${socket.id}: new_chat`);
        });
    });
}
