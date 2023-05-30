<?php

namespace Modules\Advertise\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Advertise\Entities\AdvertiseStatistics;
use Modules\Advertise\Enums\StatisticsEnum;
use Modules\Advertise\Repositories\CuApi\V1\AdvertiseRepository;
use MongoDB\BSON\UTCDateTime;

class IncrementAdvertiseViewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $advertiseId, $userId;
    private StatisticsEnum $enum;
    public int $time;

    public function __construct($advertiseId, $userId, $enum, $time)
    {
        $this->advertiseId = $advertiseId;
        $this->userId = $userId;
        $this->enum = $enum;
        $this->time = $time;
        $this->onQueue('low');
    }

    public function handle()
    {
        AdvertiseStatistics::query()->create([
            'advertise_id' => $this->advertiseId, 'user_id' => $this->userId, 'type' => $this->enum->value,'created_at' => new UTCDateTime($this->time * 1000)
        ]);
    }
}
