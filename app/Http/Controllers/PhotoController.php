<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PhotoController extends Controller
{
    public function view(Request $request, Photo $photo)
    {
        return view('photo.view', ['photo' => $photo, 'edit' => $request->query('edit')]);
    }

    public function edit(Request $request, Photo $photo)
    {
        if (!$photo->canUserModify($request->user())) {
            throw new HttpException(403);
        }

        $photo = Photo::find($request->input('photo'));
        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album');
        if ($request->user()->is_admin) {
            $photo->user_id = $request->input('photographer');
        }
        $photo->save();

        return view('photo.view', ['photo' => $photo, 'edit' => false]);
    }

    public function download(Photo $photo)
    {
        return response()->download(public_path($photo->file), basename($photo->file));
    }

    public function delete(Request $request, Photo $photo)
    {
        if (!$photo->canUserModify($request->user())) {
            throw new HttpException(403);
        }

        $photo->delete();

        return redirect(url('/album/' . $photo->album_id));
    }
}
