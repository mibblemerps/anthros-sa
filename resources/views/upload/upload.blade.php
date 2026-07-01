@extends('_template')

@section('head')
    @vite('resources/css/upload.scss')
    @vite('resources/js/upload.js')
@endsection

@section('body')
    <form action="" method="post" enctype="multipart/form-data">
        @if (session('successful_uploads'))
            <div class="alert alert-success alert-upload-result">
                The following photo(s) successfully uploaded:
                <ul>
                    @foreach (session('successful_uploads') as $upload)
                        <li>{{ $upload }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error_uploads'))
            <div class="alert alert-danger alert-upload-result">
                The following photo(s) failed to upload!
                <ul>
                    @foreach (session('error_uploads') as $upload)
                        <li>{{ $upload[0] }} - {{ $upload[1] }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Photo Upload</h1>

        <div class="upload-as">
            <div class="upload-as-current">
                <img class="avatar" src="{{ auth()->user()->avatar }}" alt="Avatar">
                <span class="username">{{ auth()->user()->name }}</span>
            </div>

            @if (auth()->user()->is_admin)
                <hr>
                <div class="upload-as-override">
                    <label for="upload-as-override-select" class="form-label"><span class="badge text-bg-info">Admin</span> Upload as another user</label>
                    <select id="upload-as-override-select" class="form-select" name="upload-as">
                        <option></option>
                        @foreach (\App\Models\User::where('id', '!=', auth()->user()->id)->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <select class="form-select" name="album">
            @foreach (\App\Models\Album::all() as $album)
                <option value="{{ $album->id }}">{{ $album->title }}</option>
            @endforeach
        </select>

        <div class="file-upload" id="file-upload">
            <i class="fa fa-cloud-arrow-up"></i>
            <p>
                <a href="#">Click to upload</a> or drag and drop
            </p>
            <p>
                PNG or JPG (max 10MiB)
            </p>
            <div class="files"></div>
        </div>

        <div class="consent card card-body">
            <h2>Consent</h2>
            <p>
                By uploading your photo here it is assumed you consent to Anthros SA hosting it on this gallery with
                credit to yourself.
            </p>
            <p>
                <b>Optionally</b>, you may give consent for your photo to be used for other Anthros SA related purposes
                such as marketing, social media, or other community purposes.
            </p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="consent" id="consent-yes" value="yes" required>
                <label for="consent-yes">
                    <span class="text-success">Yes</span> &mdash; ASSA may use this photo.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="consent" id="consent-no" value="" required>
                <label for="consent-no"><span class="text-danger">
                        No</span> &mdash; ASSA must seek explicit permission before using this photo.
                </label>
            </div>
        </div>

        <button class="btn btn-primary btn-lg"><i class="fa fa-cloud-arrow-up"></i> Upload</button>
    </form>

@endsection
