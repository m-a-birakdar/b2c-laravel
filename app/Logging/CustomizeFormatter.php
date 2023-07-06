<?php

namespace App\Logging;
use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                '*Date:*' . PHP_EOL . '%datetime%' . PHP_EOL . PHP_EOL . '*Level:*' . PHP_EOL . '%level_name%' . PHP_EOL . PHP_EOL .
                '*Message:*' . PHP_EOL . '%message%' . PHP_EOL . PHP_EOL . '*Context:*' . PHP_EOL . '%context%', 'Y-m-d H:i:s'
            ));
        }
    }
}