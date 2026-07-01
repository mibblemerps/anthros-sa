@extends('_template')

@section('head')
    @vite('resources/css/photo.scss')
@endsection

@section('body')
    <div class="view-photo">
        <div class="img-container">
            <a href="{{ $photo->file }}">
                <img src="{{ $photo->file }}" alt="{{ $photo->title ?? 'Photo' }}">
            </a>
        </div>
        <div class="photo-info">
            @if ($photo->title !== null)
                <h1>{{ $photo->title }}</h1>
            @endif
            @if ($photo->description !== null)
                <p>{{ $photo->description }}</p>
            @endif
            <table class="table">
                <tr>
                    <td><i class="fa fa-calendar"></i> Uploaded at</td>
                    <td>{{ $photo->created_at }}</td>
                </tr>
                <tr>
                    <td><i class="fa fa-camera"></i> Photographer</td>
                    <td>
                        <img src="{{ $photo->user->avatar }}" alt="Avatar" class="avatar">
                        {{ $photo->user->name }}
                    </td>
                </tr>
                <tr>
                    <td><i class="fa fa-images"></i> Album</td>
                    <td><a href="/album/{{ $photo->album->id }}">{{ $photo->album->title }}</a></td>
                </tr>
            </table>
            <div class="photo-buttons">
                <a href="{{ url('/photo/' . $photo->id . '/download') }}" class="btn btn-secondary"><i class="fa fa-download"></i> Download</a>
                @if ($photo->canUserModify(auth()->user()))
                    <form action="{{ url('/photo/' . $photo->id . '/delete') }}" method="post">
                        <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
