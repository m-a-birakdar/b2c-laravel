import { MongoClient } from "mongodb";
import { createServer } from 'http';
import { Server } from 'socket.io';
import Whatsapp from 'whatsapp-web.js';
const { Client, LocalAuth } = Whatsapp;
import qrcodeTerminal from 'qrcode-terminal';

const httpServer = createServer();
const io = new Server(httpServer, {cors: {origin: '*'}});

io.on('connection', (socket) => {
    newConnection(socket);
    const data = socket.handshake.query;
    userIds[data['user_id']] = socket.id;
    console.log(socket.id);
    console.log(`Client connected with ID ${socket.id}`);
    socket.on('disconnect', () => {
        console.log(`Client disconnected with ID ${socket.id}`);
        console.log(data);
    });
});
const allClients = [];
const userIds = [];
async function newConnection(socket)
{
    const data = socket.handshake.query;
    const mongoDbConnection = 'mongodb://127.0.0.1:27017/';
    const mongo = await MongoClient.connect(mongoDbConnection, { useNewUrlParser: true, useUnifiedTopology: true });
    const db = mongo.db(data['tenant'] + '-mongodb');
    const collection = db.collection('whatsapp_status');
    // try {
        const docs = await collection.findOne({'user_id': parseInt(data['user_id'])});
        console.log(docs);
        // if (docs[0]['status']){
        //     io.to(userIds[data['user_id']]).emit('whatsapp_status', {
        //         'status': true
        //     });
        // }

    // } catch (err) {
    //     console.error('Error retrieving documents:', err);
    // } finally {
    //     await client.close();
    // }
}
async function newClient(data)
{
    const client = new Client({authStrategy: new LocalAuth({clientId: data['tenant'],})});
    client.on('qr', qr => {
        io.to(userIds[data['user_id']]).emit('whatsapp_status', {
            'status': false,
            'message': 'Read Qr',
            'qr': qr
        });
    });

    client.on("disconnected", async (reason) => {
        io.to(userIds[data['user_id']]).emit('whatsapp_status', {
            'status': false,
            'message': 'Disconnected',
        });
        userIds.filter((value) => value !== data['user_id']);
        allClients.filter((value) => value !== data['tenant']);
        console.log("Client was logged out", reason);
    });

    client.on('ready', () => {
        console.log('ready');
        io.to(userIds[data['user_id']]).emit('whatsapp_status', {
            'status': true,
            'message': 'Ready',
        });
    });

    client.on('message', (message) => {
        console.log(message);
        client.sendMessage(message.from, message.body);
    });

    await client.initialize();
    console.log('initialize');
    allClients[data['tenant']] = client;
}

const PORT = 6001;

httpServer.listen(PORT, () => {
    console.log(`Socket.io server listening on port ${PORT}`);
});


