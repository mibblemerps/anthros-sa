<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

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
}
