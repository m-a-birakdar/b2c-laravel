<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait MediaTrait
{
    public function uploadImage($image, $dir = 'products', $status = 'public'): string
    {
        $imageName = $image->hashName();
        $image = Image::make($image)->orientate()->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        Storage::disk($this->getEnv())->put($dir . '/'. $imageName, (string) $image, $status);
        return $imageName;
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
