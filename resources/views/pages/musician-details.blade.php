@extends('layouts.app')

@section('content')
<div class="container">
    <div class="musician-profile">
        <div class="profile-header">
            @if($musician->profile_photo)
                <img src="{{ asset('storage/' . $musician->profile_photo) }}" alt="{{ $musician->user->name }}" class="profile-photo">
            @else
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile" class="profile-photo">
            @endif
            <div class="profile-info">
                <h1>{{ $musician->user->name }}</h1>
                <p class="band-name">{{ $musician->band_name }}</p>
                <p class="genre"><i class="fas fa-music"></i> {{ $musician->genre }}</p>
                @if(session()->has('user_id') && session('user_id') != $musician->user_id)
                    <a href="{{ route('musicians.book', $musician->id) }}" class="book-btn">
                        <i class="fas fa-calendar-plus"></i> Book This Musician
                    </a>
                @endif
            </div>
        </div>

        <div class="content-section">
            <h2>Latest Music</h2>
            <div class="music-grid">
                @forelse($musician->featured_music as $track)
                    <div class="music-card">
                        @if($track->image)
                            <img src="{{ asset('storage/' . $track->image) }}" alt="{{ $track->title }}" class="music-cover">
                        @else
                            <img src="{{ asset('images/default-music-cover.jpg') }}" alt="Default Cover" class="music-cover">
                        @endif
                        <div class="music-details">
                            <h3>{{ $track->title }}</h3>
                            <p class="genre"><i class="fas fa-music"></i> {{ $track->genre }}</p>
                            <div class="audio-player">
                                <audio controls>
                                    <source src="{{ asset('storage/' . $track->song_path) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-content">No music available yet.</p>
                @endforelse
            </div>

            <h2>Upcoming Events</h2>
            <div class="events-grid">
                @forelse($musician->upcoming_events as $event)
                    <div class="event-card">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image">
                        @else
                            <img src="{{ asset('images/default-event-image.jpg') }}" alt="Default Event Image" class="event-image">
                        @endif
                        <div class="event-details">
                            <h3>{{ $event->name }}</h3>
                            <p class="date"><i class="far fa-calendar"></i> {{ $event->date->format('M d, Y') }}</p>
                            <p class="time"><i class="far fa-clock"></i> {{ $event->time }}</p>
                            <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                            <p class="price"><i class="fas fa-ticket-alt"></i> ${{ number_format($event->price, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="no-content">No upcoming events scheduled.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.musician-profile {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.profile-header {
    display: flex;
    align-items: center;
    padding: 30px;
    background: linear-gradient(to right, #f8f9fa, #e9ecef);
}

.profile-photo {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 30px;
    border: 5px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.profile-info {
    flex: 1;
}

.profile-info h1 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 2.5em;
}

.band-name {
    font-size: 1.2em;
    color: #666;
    margin: 0 0 10px 0;
}

.genre {
    color: #007bff;
    font-size: 1.1em;
    margin: 0;
}

.content-section {
    padding: 30px;
}

.content-section h2 {
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
}

.music-grid, .events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.music-card, .event-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.music-card:hover, .event-card:hover {
    transform: translateY(-5px);
}

.music-cover, .event-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.music-details, .event-details {
    padding: 20px;
}

.music-details h3, .event-details h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.audio-player {
    margin-top: 15px;
}

.audio-player audio {
    width: 100%;
}

.no-content {
    text-align: center;
    color: #666;
    padding: 20px;
    grid-column: 1 / -1;
}

.date, .time, .location, .price {
    margin: 5px 0;
    color: #666;
}

.date i, .time i, .location i, .price i {
    margin-right: 8px;
    color: #007bff;
}

.book-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.book-btn:hover {
    background-color: #0056b3;
    color: white;
    text-decoration: none;
}

.book-btn i {
    margin-right: 8px;
}
</style>
@endsection 