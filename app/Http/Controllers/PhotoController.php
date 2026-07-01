<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function view(Photo $photo)
    {
        return view('photo.view', ['photo' => $photo]);
    }

    public function download(Photo $photo)
    {
        return response()->download(public_path($photo->file), basename($photo->file));
    }

    public function delete(Request $request, Photo $photo)
    {
        if (!$photo->canUserModify($request->user())) {
            return response('Forbidden.', 403);
        }

        $photo->delete();

        return redirect(url('/album/' . $photo->album_id));
    }
}
