import express from 'express';
import qrcodeTerminal from 'qrcode-terminal';
import Whatsapp from 'whatsapp-web.js'
const { Client, LocalAuth, MessageMedia } = Whatsapp;

const client = new Client({ authStrategy: new LocalAuth() });

const app = express();

app.use(express.json());

let phone = '352681584988@c.us';

app.post('/send', async (req, res) =>  {
    console.log(req.body);
    // const media = await MessageMedia.fromUrl('https://www.imtilakgroup.com/assets/images/imtilak-logo.png');
    client.sendMessage(phone, req.body['message']);
    res.status(201).json({ message: req.body });
});

app.listen(3000, () => {
    console.log(`Server listening on port `);
});

client.on('qr', qr => {
    qrcodeTerminal.generate(qr, {small: true});
});

client.on('ready', () => {
    console.log('Client is ready!');
});

client.initialize();
