<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManagement
{
    // ========== when using this class send $request->image  not $request ===================//
    public static function uploadImage($request, $message = null, $user = null, $doctor = null)
    {

        if ($user && $request->hasFile('image')):
            self::SaveUserImage($request->image, $user);
        endif;

        if ($doctor && $request->hasFile('image')):
            self::SaveDoctorImage($request->image, $doctor);
        endif;

        if ($message && $request->hasFile('content')):
            self::saveMessageType($request->content, $message);
            self::deleteImage($request->content);
        endif;

        if ($request->hasFile('image')):
            self::deleteImage($request->image);
        endif;

    }

    protected static function deleteImage($image)
    {
        if (File::exists(public_path($image))):
            File::delete(public_path($image));
        endif;
    }

    protected static function generateImageName($image, $path)
    {
        $fileName = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('uploads/' . $path, $fileName, ['disk' => 'store']);

    }

    protected static function saveUserImage($image, $user)
    {
        $path = self::generateImageName($request->image, 'users');
        $user->update([
            'image' => $path
        ]);
    }

    protected static function saveDoctorImage($image, $doctor)
    {
        $path = self::generateImageName($request->image, 'doctors');
        $doctor->update([
            'image' => $path
        ]);
    }

    protected static function saveMessageType($file, $message, $defaultPath = 'chats')
    {
        $path = match ($message->type) {
            'image' => self::generateImageName($file, "$defaultPath/images"),
            'voice' => self::generateImageName($file, "$defaultPath/voices"),
            'video' => self::generateImageName($file, "$defaultPath/videos"),
            'text' => $file->content,
        };
        $message->update([
            'content' => $path
        ]);

    }


}