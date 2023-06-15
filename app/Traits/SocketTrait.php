<?php

namespace App\Traits;

use ElephantIO\Client;

trait SocketTrait
{
    public function emit($event, $data): void
    {
        $connectionUrl = 'http://localhost:2000/?user_id=' . sanctum()->id . '&tenant=' . tenant()->id . '&type=once';
        $client = new Client(Client::engine(Client::CLIENT_4X, $connectionUrl));
        try {
            $client->initialize();
            $client->emit($event, $data);
            $client->close();
        } catch (\Exception $exception){
            echo $exception;
        }
    }
}
