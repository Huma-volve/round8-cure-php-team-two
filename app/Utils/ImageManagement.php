<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManagement
{

    protected static function uploadImage($request, $user = null, $chats = null)
    {
        if ($request->hasFile('image')):
            self::deleteImage($user->image ?? $chats->content);
        endif;

    }

    protected static function deleteImage($image)
    {
        if (File::exists(public_path($image))):
            File::delete(public_path($image));
        endif;
    }

    protected static function generateImageName($image,$path)
    {
        $fileName = Str::uuid().time().'.'.$image->getClientOriginalExtension();
        return $image->storeAs('uploads/'.$path ,$fileName , ['disk' => 'store']);

    }



}