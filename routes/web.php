<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});

Route::get('/album/{album}', [AlbumController::class, 'view']);
Route::get('/album', [AlbumController::class, 'index']);

Route::get('/photo/{photo}/download', [PhotoController::class, 'download']);
Route::post('/photo/{photo}/delete', [PhotoController::class, 'delete']);
Route::get('/photo/{photo}', [PhotoController::class, 'view']);

Route::get('/upload', [UploadController::class, 'uploader'])->name('uploader');
Route::post('/upload', [UploadController::class, 'upload']);

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return response()->redirectTo('/');
})->name('logout');

