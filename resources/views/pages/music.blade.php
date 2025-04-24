@extends('layouts.app')

@section('content')
<div class="music-container">
    <div class="music-header">
        <h1>Music</h1>
        <p>Discover and listen to amazing music from talented musicians</p>
    </div>

    @if(auth()->check())
        @if($music->isEmpty())
            <div class="empty-state">
                <h2>{{ $message }}</h2>
                <p>Here you'll find all the amazing tracks from our talented musicians.</p>
                <p>Stay tuned for new music releases!</p>
            </div>
        @else
            <div class="music-grid">
                @foreach($music as $track)
                    <div class="music-card">
                        <div class="music-cover">
                            @if($track->image)
                                <img src="{{ asset('storage/' . $track->image) }}" alt="{{ $track->title }}">
                            @else
                                <img src="{{ asset('images/default-music-cover.jpg') }}" alt="Default Cover">
                            @endif
                            <div class="play-overlay">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="music-details">
                            <h3>{{ $track->title }}</h3>
                            <p class="artist">{{ $track->musician->user->name }}</p>
                            <p class="genre">{{ $track->genre }}</p>
                            <audio controls class="audio-player">
                                <source src="{{ asset('storage/' . $track->song_path) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="login-prompt">
            <h2>Welcome to Music!</h2>
            <p>Please log in to discover and listen to amazing music.</p>
            <button class="login-btn" onclick="showPopup('login')">Log In</button>
        </div>
    @endif
</div>

<style>
    .music-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .music-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .music-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .music-header p {
        font-size: 1.1rem;
        color: #666;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 2rem 0;
    }

    .empty-state h2 {
        color: #333;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .music-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .music-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .music-card:hover {
        transform: translateY(-5px);
    }

    .music-cover {
        position: relative;
        width: 100%;
        padding-top: 100%;
        background: #f8f9fa;
    }

    .music-cover img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .music-card:hover .play-overlay {
        opacity: 1;
    }

    .play-overlay i {
        color: white;
        font-size: 3rem;
    }

    .music-details {
        padding: 1.5rem;
    }

    .music-details h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .music-details p {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .audio-player {
        width: 100%;
        margin-top: 1rem;
    }

    .login-prompt {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 2rem 0;
    }

    .login-prompt h2 {
        color: #333;
        margin-bottom: 1rem;
    }

    .login-prompt p {
        color: #666;
        margin-bottom: 1.5rem;
    }

    .login-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s ease;
    }

    .login-btn:hover {
        background: #0056b3;
    }
</style>
@endsection 