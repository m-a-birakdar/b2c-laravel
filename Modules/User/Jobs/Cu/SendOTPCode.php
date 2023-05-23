<?php

namespace Modules\User\Jobs\Cu;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOTPCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $phone;
    public string $code;

    public function __construct($phone, $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $response = Http::withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->post(env('WHATSAPP_URL') . '/send', [
            'phone' => $this->phone,
            'message' => "Test \n" . PHP_EOL . $this->code,
        ]);
        Log::info('123', [$response->json()]);
    }
}
