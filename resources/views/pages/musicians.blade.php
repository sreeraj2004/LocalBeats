@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1>Our Musicians</h1>
    <p>Browse and connect with talented local musicians.</p>

    <div class="musicians-grid">
        @foreach($musicians as $musician)
            <div class="musician-card">
                <div class="musician-header">
                    @if($musician->profile_photo)
                        <img src="{{ asset('storage/' . $musician->profile_photo) }}" alt="{{ $musician->band_name }}" class="profile-photo" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgNC44NCAyLjE3IDQuODQgNC44NCAwIDIuNjctMi4xNyA0Ljg0LTQuODQgNC44NC0yLjY3IDAtNC44NC0yLjE3LTQuODQtNC44NCAwLTIuNjcgMi4xNy00Ljg0IDQuODQtNC44NHptMCAxMmE5LjkxIDkuOTEgMCAwIDEtOC4xNi00LjQyYzAuMDQtLjExLjA5LS4yMS4xNS0uMzFDMi4yOSAxMyA0LjYxIDEzLjUgNyAxMy41YzIuNDkgMCA0LjgxLS41IDcuMTUtMS4yOS4wNi4xLjExLjIuMTUuMzFhOS45MSA5LjkxIDAgMCAxLTguMTYgNC40MnoiLz48L3N2Zz4=';">
                    @else
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgNC44NCAyLjE3IDQuODQgNC44NCAwIDIuNjctMi4xNyA0Ljg0LTQuODQgNC44NC0yLjY3IDAtNC44NC0yLjE3LTQuODQtNC44NCAwLTIuNjcgMi4xNy00Ljg0IDQuODQtNC44NHptMCAxMmE5LjkxIDkuOTEgMCAwIDEtOC4xNi00LjQyYzAuMDQtLjExLjA5LS4yMS4xNS0uMzFDMi4yOSAxMyA0LjYxIDEzLjUgNyAxMy41YzIuNDkgMCA0LjgxLS41IDcuMTUtMS4yOS4wNi4xLjExLjIuMTUuMzFhOS45MSA5LjkxIDAgMCAxLTguMTYgNC40MnoiLz48L3N2Zz4=" alt="Default Profile" class="profile-photo">
                    @endif
                    <h2>{{ $musician->band_name }}</h2>
                    <p class="genre">{{ $musician->genre }}</p>
                </div>

                <div class="musician-details">
                    <div class="stats">
                        <div class="stat">
                            <span class="label">Music Tracks</span>
                            <span class="value">{{ $musician->featured_music->count() }}</span>
                        </div>
                        <div class="stat">
                            <span class="label">Events</span>
                            <span class="value">{{ $musician->upcoming_events->count() }}</span>
                        </div>
                    </div>

                    @if($musician->featured_music->isNotEmpty())
                        <div class="latest-music">
                            <h3>Latest Music</h3>
                            @foreach($musician->featured_music->take(3) as $music)
                                <div class="music-item">
                                    <h4>{{ $music->artist_name }}</h4>
                                    <audio controls class="audio-player">
                                        <source src="{{ asset('storage/' . $music->song_path) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($musician->upcoming_events->isNotEmpty())
                        <div class="upcoming-events">
                            <h3>Upcoming Events</h3>
                            @foreach($musician->upcoming_events->take(3) as $event)
                                <div class="event-item">
                                    <h4>{{ $event->name }}</h4>
                                    <p>{{ $event->date }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.musicians-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    padding: 2rem;
}

.musician-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.musician-card:hover {
    transform: translateY(-5px);
}

.musician-header {
    text-align: center;
    padding: 1.5rem;
    background: #f8f9fa;
}

.profile-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.genre {
    color: #666;
    font-style: italic;
}

.musician-details {
    padding: 1.5rem;
}

.stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.stat {
    text-align: center;
}

.stat .label {
    display: block;
    color: #666;
    font-size: 0.9rem;
}

.stat .value {
    display: block;
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
}

.latest-music, .upcoming-events {
    margin-top: 1.5rem;
}

.music-item, .event-item {
    background: #f8f9fa;
    padding: 1rem;
    margin-bottom: 0.5rem;
    border-radius: 5px;
}

.audio-player {
    width: 100%;
    margin-top: 0.5rem;
}

h3 {
    color: #333;
    margin-bottom: 1rem;
}

h4 {
    margin: 0;
    color: #444;
}
</style>
@endsection 