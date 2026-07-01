<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Format;
use Intervention\Image\Laravel\Facades\Image;

class UploadController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }


    public function uploader()
    {
        return view('upload.upload');
    }

    public function upload(Request $request)
    {
        $consent = $request->has('consent') && ($request->input('consent') == 'yes');
        $uploadAsId = $request->input('upload-as');

        if (!$request->user()->is_admin) $uploadAsId = null; // non-admins cannot use upload as

        $uploadAs = $uploadAsId === null ? $request->user() : User::find($uploadAsId);

        $errors = [];
        $successful = [];

        foreach ($request->file('photo') as $photoUpload) {
            $photo = new Photo();
            $photo->user_id = $uploadAs->id;
            $photo->album_id = intval($request->input('album'));
            $photo->consent = $consent;

            try {
                // Generate thumbnail
                $thumb = Image::decode($photoUpload);
                $thumb->scale(null, 400);

                $filename = Str::uuid() . '.' . $photoUpload->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('photos', $photoUpload, $filename);
                Storage::disk('public')->put('thumbs/' . $filename, $thumb->encodeUsingFormat(Format::JPEG, 80));
                $photo->file = Storage::disk('public')->url('photos/' . $filename);
                $photo->thumbnail_file = Storage::disk('public')->url('thumbs/' . $filename);

                $photo->save();

                $successful[] = $photoUpload->getClientOriginalName();
            } catch (\Exception $err) {
                $errors[] = [$photoUpload->getClientOriginalName(), $err->getMessage()];
            }
        }

        return redirect()->route('uploader')->with([
            'successful_uploads' => $successful,
            'error_uploads' => $errors
        ]);
    }
}
