@extends('_template')

@section('head')
    <title>Edit Album - Anthros SA</title>
@endsection

@section('body')
    <form class="mt-4" style="width: 500px; margin: 0 auto" method="post">
        @if (isset($album))
            <h1 class="text-center">Edit Album</h1>
            <input type="hidden" name="album" value="{{ $album->id }}">
        @else
            <h1 class="text-center">Create Album</h1>
        @endif

        <div class="mb-2">
            <label for="album-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="album-title" name="title" required value="{{ isset($album) ? $album->title : '' }}">
        </div>
        <div class="mb-2">
            <label for="album-date" class="form-label">Date</label>
            <input type="date" class="form-control" id="album-date" name="date" required value="{{ isset($album) ? $album->event_date->toDateString() : '' }}">
        </div>
        <div class="mb-2">
            <label for="album-description" class="form-label">Description</label>
            <textarea class="form-control" id="album-description" name="description" required>{{ isset($album) ? $album->description : '' }}</textarea>
        </div>
        <div class="text-end">
            <button class="btn btn-primary">{{ isset($album) ? 'Save' : 'Create' }}</button>
        </div>
    </form>
@endsection
