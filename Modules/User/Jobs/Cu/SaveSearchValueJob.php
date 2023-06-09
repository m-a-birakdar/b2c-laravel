<?php

namespace Modules\User\Jobs\Cu;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\User\Entities\Search;
use MongoDB\BSON\UTCDateTime;

class SaveSearchValueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId, $time;
    private string $text;

    public function __construct($userId, $text, $time)
    {
        $this->userId = $userId;
        $this->text = $text;
        $this->time = $time;
        $this->onQueue('low');
    }

    public function handle()
    {
        Search::query()->create([
            'text' => $this->text, 'user_id' => $this->userId, 'created_at' => new UTCDateTime($this->time * 1000)
        ]);
    }
}
