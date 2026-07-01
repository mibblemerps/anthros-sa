@extends('_template')

@section('head')
    @vite('resources/css/home.scss')
    @vite('resources/js/home.js')
@endsection

@section('body')
    <div id="sub-header">
        <p>
            Anthros SA is an 18+ community for South Australian furries.
        </p>
    </div>

    <div id="stats">
        <div class="stat">
            <span class="stat-value">420</span>
            <p>members</p>
        </div>
        <div class="stat">
            <span class="stat-value">67</span>
            <p>meets to date</p>
        </div>
        <div class="stat">
            <span class="stat-value">{{ \App\Models\Photo::count() }}</span>
            <p>meet photos</p>
        </div>
    </div>

    <div class="meets">
        @foreach (\App\Models\Album::all() as $album)
            <div class="meet">
                <div class="meet-header">
                    <h2><a href="{{ url('/album/' . $album->id) }}">{{ $album->title }}</a></h2>
                    @if ($album->event_date !== null)
                        <span class="date">{{ $album->event_date->toDateString() }}</span>
                    @endif
                    <div style="flex-grow: 1"></div>
                    <a href="{{ url('/album/' . $album->id) }}" class="btn btn-primary"><i class="fa fa-images"></i> View Gallery</a>
                </div>
                @if ($album->description !== null)
                    <p class="description">{{ $album->description }}</p>
                @endif
                <div class="meet-slideshow">
                    @include('home._slides', ['photos' => $album->photos])
                </div>
            </div>
        @endforeach
    </div>
@endsection
