
import Whatsapp from 'whatsapp-web.js'
const { Client, LocalAuth } = Whatsapp;
import mongoose from 'mongoose';
import { MongoStore } from "wwebjs-mongo";
import express from "express";

const app = express();

app.use(express.json());


app.listen(3000, () => {
    console.log(`Server listening on port `);
});
const client = new Client({
    puppeteer: {
        args: [
            "--no-sandbox",
            "--disable-setuid-sandbox",
            "--disable-dev-shm-usage",
            "--disable-accelerated-2d-canvas",
            "--no-first-run",
            "--no-zygote",
            "--single-process", // <- this one doesn't works in Windows
            "--disable-gpu",
            "--disable-infobars"
        ]
    },
    authStrategy: new LocalAuth({
        clientId: 1,
    })
});

client.on("disconnected", async (reason) => {
    console.log("Client was logged out", reason);
});

client.on('remote_session_saved', () => {
    console.log('true');
});
client.on('ready', () => {
    console.log('Client is ready!');
});
client.on('message', (message) => {
    console.log(message.body)
});

client.initialize();

app.post('/send', async (req, res) =>  {
    let phone = '905352646729@c.us';
    console.log('truedasd');
    await client.sendMessage(phone, 'test');
    res.status(200).json({ status: true});
});

// Load the session data
// mongoose.connect('mongodb://127.0.0.1:27017/test').then(() => {
//     const store = new MongoStore({ mongoose });
//
//
// });
