<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait GenerateImageTrait
{
    public function generate()
    {
        QrCode::backgroundColor(0, 255, 0, 0)->color(255,255,255)->eye('circle')->size(100)->format('png')->generate('Your QR code data', public_path('qr.png'));

        $img = Image::make(public_path('123.png'));
        $check = Image::make(public_path('check-mark.png'))->resize(60, 60);
        $img2 = Image::make(public_path('qr.png'))->resize(200, 200);
        $img->text('Amer', 0, 140, function($font) {
            $font->file(public_path('Cairo-Regular.ttf'));
            $font->size(60);
            $font->color('#750000');
        });
        $img->insert($img2, 'bottom-right', 10, 10);
        $img->insert($check, 'top-right', 10, 10);
        $img->save(public_path('new.png'));
    }
}
