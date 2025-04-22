@extends('layouts.app')

@section('content')
<div class="content">
    <div class="header">
        <h1>Welcome to LocalBeats</h1>
        <p>Discover and share local music events</p>
    </div>

    @if(session()->has('user_id') && $currentMusician)
        <div class="buttons">
            <button id="addEventBtn" class="btn-primary">
                <i class="fas fa-calendar-plus"></i> Add Event
            </button>
            <button id="addMusicBtn" class="btn-primary">
                <i class="fas fa-music"></i> Add Music
            </button>
        </div>
    @endif

    <div class="events-section">
        <h2>Upcoming Events</h2>
        <div class="events-grid">
            @foreach($events as $event)
                <div class="event-card">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}">
                    <h3>{{ $event->name }}</h3>
                    <p class="date">{{ $event->date->format('M d, Y') }}</p>
                    <p class="location">{{ $event->location }}</p>
                    <p class="description">{{ $event->description }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="music-section">
        <h2>Latest Music</h2>
        <div class="music-grid">
            @foreach($music as $track)
                <div class="music-card">
                    <img src="{{ asset('storage/' . $track->image) }}" alt="{{ $track->artist_name }}">
                    <h3>{{ $track->artist_name }}</h3>
                    <p class="genre">{{ $track->genre }}</p>
                    <p class="ratings">Rating: {{ $track->ratings }}/5</p>
                    <audio controls>
                        <source src="{{ asset('storage/' . $track->song_path) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, checking popup elements...');
        const eventPopup = document.getElementById('eventFormPopup');
        const musicPopup = document.getElementById('musicFormPopup');
        console.log('Event Form Popup:', eventPopup);
        console.log('Music Form Popup:', musicPopup);
    });
</script>
@endsection 