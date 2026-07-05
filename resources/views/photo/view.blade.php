@extends('_template')

@section('head')
    <title>Photo - Anthros SA</title>

    @vite('resources/css/photo.scss')
@endsection

@section('body')
    @if ($edit)
        <form action="" method="post">
            <input type="hidden" name="photo" value="{{ $photo->id }}">
    @endif

    <div class="view-photo">
        <div class="img-container">
            <a href="{{ $photo->file }}">
                <img src="{{ $photo->file }}" alt="{{ $photo->title ?? 'Photo' }}">
            </a>
        </div>
        <div class="photo-info">
            @if ($edit)
                <input type="text" name="title" class="form-control mb-2" value="{{ $photo->title }}" placeholder="Title">
                <textarea name="description" class="form-control mb-2" rows="3" placeholder="Description">{{ $photo->description }}</textarea>
            @else
                @if ($photo->title !== null)
                    <h1>{{ $photo->title }}</h1>
                @endif
                @if ($photo->description !== null)
                    <p>{{ $photo->description }}</p>
                @endif
            @endif

            <table class="table">
                <tr>
                    <td><i class="fa fa-calendar"></i> Uploaded at</td>
                    <td>{{ $photo->created_at }}</td>
                </tr>
                <tr>
                    <td><i class="fa fa-camera"></i> Photographer</td>
                    @if ($edit)
                        <td>
                            <select class="form-select" name="photographer" {{ auth()->user()->is_admin ? '' : 'disabled' }}>
                                @foreach (\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{( $user->id === $photo->user_id ? 'selected' : '' )}}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    @else
                        <td>
                            <img src="{{ $photo->user->avatar }}" alt="Avatar" class="avatar">
                            {{ $photo->user->name }}
                        </td>
                    @endif
                </tr>
                <tr>
                    <td><i class="fa fa-images"></i> Album</td>
                    @if ($edit)
                        <td>
                            <select class="form-select" name="album">
                                @foreach (\App\Models\Album::all() as $album)
                                    <option value="{{ $album->id }}">{{ $album->title }}</option>
                                @endforeach
                            </select>
                        </td>
                    @else
                        <td><a href="/album/{{ $photo->album->id }}">{{ $photo->album->title }}</a></td>
                    @endif
                </tr>
            </table>
            @if ($edit)
                    <div class="photo-buttons">
                        <a class="btn btn-secondary" href="{{ url('/photo/' . $photo->id) }}">Cancel</a>
                        <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    </div>
            @else
                <div class="photo-buttons">
                    <a href="{{ url('/photo/' . $photo->id . '/download') }}" class="btn btn-secondary"><i class="fa fa-download"></i> Download</a>
                    @if ($photo->canUserModify(auth()->user()))
                        <a class="btn btn-primary" href="{{ url('/photo/' . $photo->id . '?edit=1') }}"><i class="fa fa-pencil"></i> Edit</a>
                        <form action="{{ url('/photo/' . $photo->id . '/delete') }}" method="post" data-submit-confirmation="Are you sure you want to delete this photo?">
                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if ($edit)
        </form>
   @endif
@endsection
