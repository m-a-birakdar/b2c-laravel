<?php

namespace App\Traits;

use ElephantIO\Client;

trait SocketTrait
{
    public function emit(): void
    {
        $client = new Client(Client::engine(Client::CLIENT_4X, 'http://localhost:2000'));
        try {
            $client->initialize();
            $client->of('/');
            $client->emit('new_order', ['sender_id' => rand(1,100), 'chat_id' => rand(1,100)]);
            $client->close();
        } catch (\Exception $exception){
            echo $exception;
            $client->close();
        }
    }
}
