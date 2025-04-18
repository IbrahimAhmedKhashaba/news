<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image as ImageFacade;

trait UploadImage
{


    public function uploadImage($image, $path, $disk)
    {
        $resizedImage = ImageFacade::read($image)->resize(300, 300);
        $filename = Str::uuid() . time() . '_' . $image->getClientOriginalName();
        $storagePath = $path . '/' . $filename;
        \Storage::disk($disk)->put($storagePath, (string) $resizedImage->encode());
        return $storagePath;
    }


    public function deleteImage($path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
