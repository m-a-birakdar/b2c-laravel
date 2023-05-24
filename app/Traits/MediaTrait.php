<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait MediaTrait
{
    public function uploadImage($image, $dir = 'products', $status = 'public'): string
    {
        $image = Image::make($image)->orientate()->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        $name = md5(time() . rand(0, 800000)) . "." . Str::after($image->mime(), '/');
        Storage::disk($this->getEnv())->put($dir . '/'. $name, (string) $image, $status);
        return $name;
    }

    public function unlinkImage($image): void
    {
        Storage::disk($this->getEnv())->delete($image);
    }

    protected function getEnv(): string
    {
        return ! app()->environment('local') ? 's3' : 'local';
    }
}
