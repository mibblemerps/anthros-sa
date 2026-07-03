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

    @php
    $stats = \App\Statistics::get();
    @endphp
    @if ($stats)
        <div id="stats">
            <div class="stat">
                <span class="stat-value">{{ $stats->memberCount }}</span>
                <p>members and counting!</p>
            </div>
        </div>
    @endif

    <div class="meets">
        @foreach (\App\Models\Album::orderByDesc('event_date')->get() as $album)
            @php
                // skip empty albums
                if (count($album->photos) === 0 && (auth()->user() === null || !auth()->user()->is_admin)) continue;
            @endphp


            <div class="meet">
                <div class="meet-header">
                    <h2><a href="{{ url('/album/' . $album->id) }}">{{ $album->title }}</a></h2>
                    @if ($album->event_date !== null)
                        <span class="date">{{ $album->event_date->format('d/m/Y') }}</span>
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
