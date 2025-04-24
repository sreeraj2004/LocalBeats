@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">All Music</h1>
    
    @if($message)
        <p class="alert">{{ $message }}</p>
    @endif

    <div class="music-grid">
        @foreach($music as $track)
            <div class="music-card">
                @if($track->image)
                    <img src="{{ asset('storage/' . $track->image) }}" alt="{{ $track->title }}" class="music-cover">
                @else
                    <img src="{{ asset('images/default-music-cover.jpg') }}" alt="Default Cover" class="music-cover">
                @endif
                <div class="music-details">
                    <h3>{{ $track->title }}</h3>
                    <p class="artist-name">By: {{ $track->musician->user->name }}</p>
                    <p class="genre"><i class="fas fa-music"></i> {{ $track->genre }}</p>
                    <div class="audio-player">
                        <audio controls>
                            <source src="{{ asset('storage/' . $track->song_path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
    font-size: 2.5em;
}

.alert {
    text-align: center;
    padding: 15px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.music-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    padding: 20px;
}

.music-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.music-card:hover {
    transform: translateY(-5px);
}

.music-cover {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.music-details {
    padding: 20px;
}

.music-details h3 {
    margin: 0 0 15px 0;
    color: #333;
    font-size: 1.4em;
}

.music-details p {
    margin: 10px 0;
    color: #666;
}

.music-details i {
    margin-right: 8px;
    color: #007bff;
}

.artist-name {
    color: #007bff !important;
    font-weight: 500;
}

.audio-player {
    margin-top: 15px;
    width: 100%;
}

.audio-player audio {
    width: 100%;
    height: 40px;
}
</style>
@endsection 