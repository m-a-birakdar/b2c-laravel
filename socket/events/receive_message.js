import { insertObject } from '../opperations/mongo.js'
import { ObjectId } from "mongodb";

export function receiveMessage(io, socket) {
    socket.on('receive_message', (data) => {
        io.emit('receive_message', data);
        insertObject('messages', {
            sender_id: data['sender_id'],
            chat_id: new ObjectId(data['chat_id']),
            text: data['text'],
            read_at: null,
            created_at: new Date(),
        }).then(() => {
            console.log(`Received message from client ${socket.id}: receive_message`);
        });
    });
}
