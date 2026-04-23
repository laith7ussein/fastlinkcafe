<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

final class MenuItemImageService
{
    private const SIZE = 900;

    public function storeCroppedSquare(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file->getRealPath());
        $image->cover(self::SIZE, self::SIZE);

        $relative = 'menu-items/'.Str::uuid().'.jpg';
        Storage::disk('public')->makeDirectory('menu-items');
        $absolute = Storage::disk('public')->path($relative);

        $image->toJpeg(quality: 88)->save($absolute);

        return Storage::disk('public')->url($relative);
    }
}
