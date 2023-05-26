import express from 'express';
import qrcodeTerminal from 'qrcode-terminal';
import Whatsapp from 'whatsapp-web.js'
const { Client, LocalAuth, MessageMedia } = Whatsapp;
import { insertObject } from '../socket/opperations/mongo.js'
const client = new Client({ authStrategy: new LocalAuth() });

const app = express();

app.use(express.json());


app.post('/send', async (req, res) =>  {
    let phone = req.body['phone'] + '@c.us';
    let da;
    if (req.body['media'] == null){
        da = await client.sendMessage(phone, req.body['message']);
    } else {
        const media = await MessageMedia.fromUrl(req.body['media']);
        da = await client.sendMessage(phone, media, {caption: req.body['message']});
    }
    res.status(200).json({ status: true, id: da._data.id.id });
});

client.on('message_ack', (msg) => {
    insertObject('message_ack', {
        message_id: msg._data.id.id, ack: msg._data.ack, created_at: new Date(),
    });
});

client.on('change_state', state => {
    insertObject('whatsapp', {
        type: 'change_state', message: state, created_at: new Date(),
    });
});

client.on('disconnected', (reason) => {
    insertObject('whatsapp', {
        type: 'change_state', message: reason, created_at: new Date(),
    });
});

client.on('auth_failure', msg => {
    insertObject('whatsapp', {
        type: 'auth_failure', message: msg, created_at: new Date(),
    });
});

app.listen(3000, () => {
    console.log(`Server listening on port `);
});

client.on('qr', qr => {
    qrcodeTerminal.generate(qr, {small: true});
});

client.on('ready', () => {
    console.log('Client is ready!');
    insertObject('whatsapp', {
        type: 'ready', message: 'Ready', created_at: new Date(),
    });
});

client.initialize();
