<div class="embla">
    <div class="embla__viewport">
        <div class="embla__container">
            @foreach ($photos as $photo)
                <div class="embla__slide">
                    <a href="/photo/{{ $photo->id }}">
                        <img src="{{ $photo->thumbnail_file }}" alt="{{ $photo->title ?? 'Photo' }}">
                    </a>
                    <div class="photo-credit"><i class="fa fa-camera"></i> {{ $photo->user->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
