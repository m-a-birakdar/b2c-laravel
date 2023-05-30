<?php

namespace Modules\Product\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Product\Entities\ProductStatistics;
use Modules\Product\Enums\StatisticsEnum;
use MongoDB\BSON\UTCDateTime;

class ProductStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $time;
    public int|array|string $id;
    public int $userId;
    public StatisticsEnum $enum;

    public function __construct($id, $userId, $enum, $time)
    {
        $this->id = (array) $id;
        $this->enum = $enum;
        $this->userId = (int) $userId;
        $this->time = $time;
        $this->onQueue('low');
    }

    public function handle()
    {
        $array = [];
        foreach ($this->id as $item)
            $array[] = [
                'product_id' => (int) $item, 'user_id' => $this->userId, 'type' => $this->enum->value, 'created_at' => new UTCDateTime($this->time * 1000)
            ];
        ProductStatistics::query()->insert($array);
    }
}
