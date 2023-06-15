<?php

namespace Modules\Order\Console;

use ElephantIO\Client;
use Illuminate\Console\Command;
use Modules\Order\Repositories\AdApi\V1\OrderRepository;

class NewOrderSocketListenerCommand extends Command
{
    protected $name = 'socket:new-order';

    protected $description = 'New order socket listener command.';

    public function handle()
    {
        $connectionUrl = 'http://localhost:2000/?user_id=123&tenant=vvv&type=once';

        $client = new Client(Client::engine(Client::CLIENT_4X, $connectionUrl));
        try {
            $client->initialize();
            while (true) {

                $memoryUsage = memory_get_usage();

                if ($result = $client->wait('new_order')){

                    tenancy()->initialize($result->data['tenant']);

                    (new OrderRepository )->toShipment([
                        'courier_id' => $result->data['user_id'],
                        'order_id' => $result->data['order_id'],
                    ]);
                }
                $peakMemoryUsage = memory_get_peak_usage();
                $formattedMemoryUsage = $this->formatMemory($memoryUsage);
                $formattedPeakMemoryUsage = $this->formatMemory($peakMemoryUsage);
                $this->info("Memory Usage: $formattedMemoryUsage");
                $this->info("Peak Memory Usage: $formattedPeakMemoryUsage");
            }
        } catch (\Exception $exception){
            echo $exception;
        }
        $client->close();
    }

    function formatMemory($bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . $units[$i];
    }
}
