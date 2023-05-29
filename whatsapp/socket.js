import {createServer} from "http";
import {Server} from "socket.io";
import Whatsapp from 'whatsapp-web.js'
const { Client, LocalAuth, MessageMedia } = Whatsapp;

const httpServer = createServer();
const io = new Server(httpServer, {cors: {origin: '*'}});

const allClients = {};
const client = new Client({ authStrategy: new LocalAuth({clientId: 123}) });
console.log(client);
client.on('qr', qr => {
    console.log('qr_text');
});
// io.on('connection', (socket) => {
//     console.log(`Client connected with ID ${socket.id}`);
//     console.log(allClients);
//     const data = socket.handshake.query;
//     console.log(data['id']);
//     if (allClients.hasOwnProperty(data['id'])){
//         console.log('Ready');
//         socket.emit('status', {
//             text: 'Ready'
//         });
//     } else {
//         console.log('QR');
//         socket.emit('status', {
//             text: 'QR'
//         });
//         const client = new Client({ authStrategy: new LocalAuth({clientId: data['id']}) });
//         console.log(client);
//         client.on('qr', qr => {
//             console.log('qr_text');
//             socket.emit('qr_text', {
//                 text: qr
//             });
//         });
//         client.on('ready', () => {
//             allClients[data['id']] = client;
//             socket.emit('ready', {
//                 text: 'QR'
//             });
//             console.log('Client is ready!');
//         });
//     }
// });

const PORT = 6001;
httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});
