<?php

namespace App\Http\Controllers;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

abstract class Controller
{
    //
    function resizeAndUpload($image, $path, $width = 400, $height = 400, $fsize = null)
    {
        $imageName = now()->format('Ymd-his') . rand(1000, 9999) . '.jpg';
        $img = Image::read($image)
            ->cover($width, $height); 
        $originalSize = $image->getSize(); 
        $fullPath = public_path($path);
        // directory check & create
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true); // recursive create
        }
        $finalPath = public_path($path . '/' . $imageName);
        // if compression needed
        if ($fsize && $originalSize > $fsize * 1024) {
            $quality = 90;
            do {
                $encoded = $img->toJpeg($quality);
                $size = strlen($encoded);
                $quality -= 5;
            } while ($size > $fsize * 1024 && $quality > 10);

            file_put_contents($finalPath, $encoded);

        } else {
            $img->toJpeg(90)->save($finalPath);
        }

        return $imageName;
    }

    function uploadImg($image, $path)
    {
        // extension detect
        $extension = $image->getClientOriginalExtension();

        // unique image name
        $imageName = now()->format('Ymd-his') . rand(1000, 9999) . '.' . $extension;

        // full path
        $fullPath = public_path($path);

        // directory create if not exists
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // move original image
        $image->move($fullPath, $imageName);

        return $imageName;
    }
}
