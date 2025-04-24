@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">All Events</h1>
    
    @if($message)
        <p class="alert">{{ $message }}</p>
    @endif

    <div class="event-grid">
        @foreach($events as $event)
            <div class="event-card">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="event-image">
                @else
                    <img src="{{ asset('images/default-event-image.jpg') }}" alt="Default Event Image" class="event-image">
                @endif
                <div class="event-details">
                    <h3>{{ $event->name }}</h3>
                    <p class="artist-name">By: {{ $event->musician->user->name }}</p>
                    <p class="event-date"><i class="far fa-calendar"></i> {{ $event->date->format('M d, Y') }}</p>
                    <p class="event-time"><i class="far fa-clock"></i> {{ $event->time }}</p>
                    <p class="event-location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                    <p class="event-price"><i class="fas fa-ticket-alt"></i> ${{ number_format($event->price, 2) }}</p>
                    <button class="book-event-btn" onclick="bookEvent({{ $event->id }})">
                        <i class="fas fa-ticket-alt"></i> Book Event
                    </button>
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

.event-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    padding: 20px;
}

.event-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
}

.event-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-details {
    padding: 20px;
}

.event-details h3 {
    margin: 0 0 15px 0;
    color: #333;
    font-size: 1.4em;
}

.event-details p {
    margin: 10px 0;
    color: #666;
}

.event-details i {
    margin-right: 8px;
    color: #007bff;
}

.artist-name {
    color: #007bff !important;
    font-weight: 500;
}

.book-event-btn {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1em;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.book-event-btn:hover {
    background-color: #0056b3;
}

.book-event-btn i {
    color: white !important;
    margin-right: 0 !important;
}
</style>

<script>
// Pass PHP variables to JavaScript
const isLoggedIn = @json($isLoggedIn);
const userId = @json($userId);

function bookEvent(eventId) {
    if (!isLoggedIn) {
        alert('Please log in to book an event');
        return;
    }
    
    // TODO: Implement booking functionality
    alert('Booking functionality coming soon!');
}
</script>
@endsection 