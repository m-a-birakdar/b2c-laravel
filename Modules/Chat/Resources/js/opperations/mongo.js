import { MongoClient } from "mongodb";

const mongoDbConnection = 'mongodb://127.0.0.1:27017/';

export async function insertObject(dbName, collection, object) {
    const client = await MongoClient.connect(mongoDbConnection, { useNewUrlParser: true, useUnifiedTopology: true });
    try {
        const db = client.db(dbName);
        console.log(object);
        await db.collection(collection).insertOne(object);
    } finally {
        await client.close();
    }
}
