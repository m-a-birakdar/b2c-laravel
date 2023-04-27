import { insertObject } from '../opperations/mongo.js'
import { ObjectId } from "mongodb";

let users = [];

export function chat(socket) {
    socket.on('new_chat', (data) => {
        socket.to(users[data['chat_id']]).emit('new_chat', data);
        insertObject('chats', {
            user1_id: data['user1_id'], user2_id: data['user2_id'], created_at: new Date(),
        }).then(() => {
            console.log(`Received message from client ${socket.id}: new_chat`);
        });
    });

    socket.on('receive_message', (data) => {
        socket.to(users[data['chat_id']]).emit('receive_message', data);
        insertObject('messages', {
            sender_id: data['sender_id'], chat_id: new ObjectId(data['chat_id']), text: data['text'], read_at: null, created_at: new Date(),
        }).then(() => {
            console.log(`Received message from client ${socket.id}: receive_message`);
        });
    });

    socket.on('connected', (data) => {
        users[data['id']] = socket.id;
    });
}
