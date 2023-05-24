<?php

namespace Modules\Advertise\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Advertise\Repositories\CuApi\V1\AdvertiseRepository;

class IncrementAdvertiseViewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
        $this->onQueue('low');
    }

    public function handle()
    {
        $repo = new AdvertiseRepository();
        foreach ($this->ids as $id)
            $repo->increment('views', $id);
    }
}
