<?php

namespace Modules\Cart\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Cart\Emails\AbandonedCartRecoveryMail;

class AbandonedCartRecoveryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $to, public array $products)
    {
        $this->onQueue('low');
    }

    public function handle()
    {
        Mail::to($this->to)->send(new AbandonedCartRecoveryMail($this->products));
    }
}
