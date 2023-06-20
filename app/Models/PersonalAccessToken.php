<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken as Sanctum;

class PersonalAccessToken extends Sanctum
{
    public static int $ttl = 3600;

    public static string $newToken;

    public static function findToken($token): ?static
    {
        self::$newToken = $token;
        return Cache::remember("personal-access-token:$token", self::$ttl, function () use ($token) {
            if (! str_contains($token, '|')) {
                return static::where('token', hash('sha256', $token))->first();
            }

            [$id, $token] = explode('|', $token, 2);

            if ($instance = static::find($id)) {
                return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
            }
            return null;
        });
    }

    public function tokenable(): Attribute
    {
        return Attribute::make(function ($value, $attributes) {
            return Cache::remember("personal-access-token:" . self::$newToken . ":tokenable", self::$ttl, function () {
                return parent::tokenable()->first();
            });
        });
    }

    public static function booted()
    {
        // disable last_used_at every query
        static::updating(function (self $accessToken) {
            $dirty = $accessToken->getDirty();
            return ! (count($dirty) === 1 && isset($dirty['last_used_at']));
        });
    }
}
