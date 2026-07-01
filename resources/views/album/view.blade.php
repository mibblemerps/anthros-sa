@extends('_template')

@section('head')
    @vite('resources/css/album.scss')
@endsection

@section('body')
    <header class="album-header">
        <h1>{{ $album->title }}</h1>
        <p>{{ $album->description }}</p>
    </header>
    <div class="photos">
        @foreach ($album->photos as $photo)
            <div class="photo">
                <a href="{{ url('/photo/' . $photo->id) }}">
                    <img src="{{ $photo->thumbnail_file }}" alt="{{ $photo->title ?? 'Photo' }}">
                </a>
                <footer>
                    <div class="photo-description">
                        @if ($photo->description !== null)
                            <p>{{ $photo->description }}</p>
                        @endif
                    </div>
                    <div class="photo-credit">
                        📷 <span>{{ $photo->user->name }}</span>
                    </div>
                </footer>
            </div>
        @endforeach
    </div>
@endsection
