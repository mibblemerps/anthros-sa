@extends('_template')

@section('head')
    @vite('resources/css/album.scss')
@endsection

@section('body')
    <header class="album-header">
        <h1>{{ $album->title }}</h1>
        <h2>{{ $album->event_date->format('d/m/Y') }}</h2>
        @if (auth()->user()->is_admin)
            <div class="d-flex justify-content-center gap-1">
                <a href="{{ url('/album/' . $album->id . '/edit') }}" class="btn btn-sm btn-primary album-edit-btn"><i class="fa fa-edit"></i> Edit</a>
                <form action="{{ url('/album/' . $album->id . '/delete') }}" method="post" class="p-0" data-submit-confirmation="Are you sure you want to delete {{ $album->title }}?">
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        @endif
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
