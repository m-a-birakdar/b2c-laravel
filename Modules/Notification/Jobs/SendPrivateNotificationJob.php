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
    private string|null $fcmToken, $serverToken;
    private int $userId;
    private $notification;
    private User|null $user;

    public function __construct(string $title, string $body, int $userId, string $priority = 'default', string $role = 'customer')
    {
        $this->title = $title;
        $this->body = $body;
        $this->role = $role;
        $this->userId = $userId;
        $this->onQueue($priority);
    }

    public function handle()
    {
        $this->setToken();
        if ($this->serverToken){
            $this->getUser();
            if ($this->fcmToken){
                $this->save();
                $this->send();
            } else {
                Log::channel('notification')->error('user id ' . $this->userId . ' Not have fcm token');
            }
        }
    }

    private function getUser()
    {
        $this->user = (new UserRepository())->find($this->userId, 'details:id,user_id,fcm_token', ['id']);
        $this->fcmToken = $this->user->details?->fcm_token;
    }

    private function save()
    {
        $this->notification = Notification::create([
            'user_id' => $this->userId, 'title' => $this->title, 'body' => $this->body, 'type' => NotificationTypeEnum::ORDER,
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
//        if (! is_null($initial)){
//            $data['data'] = [
//                'initial_message' => $initial,
//                'initial_id' => $notificationId,
//            ];
//        }
//        $res = Http::withHeaders(['Content-Type' => 'application/json'])->withToken($this->serverToken)->post("https://fcm.googleapis.com/fcm/send", $data);
//        if (! $res->successful())
            Log::channel('notification')->error('user id ' . $this->userId, [$data]);
    }
}
