<?php

namespace Modules\Notification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Enums\NotificationTypeEnum;
use Modules\User\Entities\User;
use Modules\User\Enums\UserRolesEnum;
use Modules\User\Repositories\Web\UserRepository;

class SendPrivateNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $role, $title, $body;
    private string|null $fcmToken, $serverToken = 'test';
    private User|null|int $user;

    public function __construct(string $title, string $body, $user, string $priority = 'default', string $role = 'customer')
    {
        $this->title = $title;
        $this->body = $body;
        $this->role = $role;
        $this->user = $user;
        $this->onQueue($priority);
    }

    private function env()
    {
        if (! app()->environment('local') )
            $this->setToken();
    }

    public function handle()
    {
        $this->env();
        $this->getUser();
        if ($this->fcmToken){
            $this->save();
//            $this->send();
        } else {
            Log::channel('notification')->error('user id ' . $this->user->id . ' Not have fcm token');
        }
    }

    private function getUser()
    {
        if (! $this->user instanceof User)
            $this->user = (new UserRepository())->find($this->user, 'details:id,user_id,fcm_token', ['id']);
        $this->fcmToken = $this->user->details?->fcm_token;
    }

    private function save()
    {
        Notification::create([
            'user_id' => $this->user->id, 'title' => $this->title, 'body' => $this->body, 'type' => NotificationTypeEnum::ORDER->value,
        ]);
    }

    private function setToken()
    {
        $this->serverToken = match ($this->role){
            UserRolesEnum::ADMIN->value     => env('FCM_TOKEN_' . UserRolesEnum::ADMIN->name),
            UserRolesEnum::CUSTOMER->value  => env('FCM_TOKEN_' . UserRolesEnum::CUSTOMER->name),
            UserRolesEnum::COURIER->value   => env('FCM_TOKEN_' . UserRolesEnum::COURIER->name),
            default => throw new \Exception('Unexpected match value'),
        };
    }

    private function send()
    {
        $data = [
            'priority' => 'high', 'to' => $this->fcmToken,
            'notification' => ['body' => $this->body, 'title' => $this->title],
        ];
        if (app()->environment('local')){
            Log::channel('notification')->info('user id ' . $this->user->id, [$data]);
        } else {
            $res = Http::contentType('application/json')->withToken($this->serverToken)->post("https://fcm.googleapis.com/fcm/send", $data);
            if (! $res->successful())
                Log::channel('notification')->error('user id ' . $this->user->id, [$data]);
        }
    }
}
