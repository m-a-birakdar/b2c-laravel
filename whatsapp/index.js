import express from 'express';
import qrcodeTerminal from 'qrcode-terminal';
import Whatsapp from 'whatsapp-web.js'
const { Client, LocalAuth, MessageMedia } = Whatsapp;

const client = new Client({ authStrategy: new LocalAuth() });

const app = express();

app.use(express.json());


app.post('/send', async (req, res) =>  {
    let phone = req.body['phone'] + '@c.us';
    if (req.body['media'] == null){
        client.sendMessage(phone,  req.body['message']);
    } else {
        const media = await MessageMedia.fromUrl(req.body['media']);
        client.sendMessage(phone, media);
    }
    console.log(req.body);
    res.status(200).json({ status: true });
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
