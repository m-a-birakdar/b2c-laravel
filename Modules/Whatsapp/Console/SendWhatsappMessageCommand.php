<?php

namespace Modules\Whatsapp\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Whatsapp\Entities\Whatsapp;
use Modules\Whatsapp\Enums\StatusEnum;

class SendWhatsappMessageCommand extends Command
{
    protected $name = 'whatsapp:send';

    protected $description = 'Send whatsapp message command.';

    public function handle()
    {
        $messages = Whatsapp::query()->whereNull('send_at')->where('status', StatusEnum::PENDING)->orderByRaw("CASE
                        WHEN priority = 'high' THEN 1
                        WHEN priority = 'default' THEN 2
                        WHEN priority = 'low' THEN 3
                        ELSE 4 END")
            ->orderBy('id')->limit(10)->get();
        foreach ($messages as $message) {
            $response = Http::contentType('application/json')->acceptJson()->post(env('WHATSAPP_URL') . '/send', [
                'phone' => $message->phone,
                'message' => $message->message,
                'media' => $message->media,
            ]);
            if($response->json('status')){
                $message->update([
                    'status' => StatusEnum::SENT,
                    'send_at' => now()
                ]);
            } else {
                $message->update([
                    'status' => StatusEnum::FIELD,
                    'send_at' => now()
                ]);
            }
            sleep(5);
        }
    }
}
