<?php

namespace App\Http\Traits;

use File;

trait ImageHandleTraits
{
    public function uploadImage($image, $path)
    {
        $newName = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path($path), $newName);

        return $newName;
    }


    public function deleteImage($image, $path)
    {
        $oldImagePath = public_path() . '/images/' . $path . '/' . $image;

        if (File::exists($oldImagePath)) {
            return File::delete($oldImagePath);
        } else {
            return 'no image';
        }
    }
}
