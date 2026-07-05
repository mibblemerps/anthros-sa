<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AlbumController extends Controller
{
    public function index()
    {
        return view('album.index');
    }

    public function view(Album $album)
    {
        return view('album.view', ['album' => $album]);
    }

    public function edit(\Illuminate\Http\Request $request, Album $album)
    {
        if ($request->isMethod('GET')) {
            return view('album.edit', ['album' => $album]);
        }

        $this->validate($request);

        $album = Album::find($request->input('album'));
        $album->title = $request->input('title');
        $album->event_date = $request->input('date');
        $album->description = $request->input('description');
        $album->save();

        return redirect('/album/' . $album->id);
    }

    public function create(\Illuminate\Http\Request $request)
    {
        if (!$request->user()->is_admin) {
            throw new HttpException(403, 'Forbidden');
        }

        if ($request->isMethod('GET')) {
            return view('album.edit');
        }

        $this->validate($request);

        $album = new Album();
        $album->title = $request->input('title');
        $album->event_date = $request->input('date');
        $album->description = $request->input('description');
        $album->save();

        return redirect('/album/' . $album->id);
    }

    public function delete(Album $album)
    {
        $album->delete();

        return redirect('/');
    }

    private function validate(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3', 'unique:albums'],
            'date' => ['required', 'date'],
            'description' => ['max:2048'],
        ]);
    }
}
