@extends('layouts.app')

@section('content')
<div class="events-container">
    <div class="events-header">
        <h1>Events</h1>
        <p>Discover upcoming music events and performances</p>
    </div>

    @if(auth()->check())
        @if($events->isEmpty())
            <div class="empty-state">
                <h2>{{ $message }}</h2>
                <p>Here you'll find all upcoming music events and performances.</p>
                <p>Stay tuned for exciting events from your favorite musicians!</p>
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                    <div class="event-card">
                        <div class="event-date">
                            <span class="day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                            <span class="month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                        </div>
                        <div class="event-details">
                            <h3>{{ $event->name }}</h3>
                            <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                            <p class="time"><i class="fas fa-clock"></i> {{ $event->time }}</p>
                            <p class="price"><i class="fas fa-ticket-alt"></i> ${{ number_format($event->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="login-prompt">
            <h2>Welcome to Events!</h2>
            <p>Please log in to view upcoming events and performances.</p>
            <button class="login-btn" onclick="showPopup('login')">Log In</button>
        </div>
    @endif
</div>

<style>
    .events-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .events-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .events-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .events-header p {
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

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .event-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-5px);
    }

    .event-date {
        background: #007bff;
        color: white;
        padding: 1rem;
        text-align: center;
    }

    .event-date .day {
        font-size: 2rem;
        font-weight: bold;
        display: block;
    }

    .event-date .month {
        font-size: 1.2rem;
        text-transform: uppercase;
    }

    .event-details {
        padding: 1.5rem;
    }

    .event-details h3 {
        color: #333;
        margin-bottom: 1rem;
    }

    .event-details p {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .event-details i {
        margin-right: 0.5rem;
        color: #007bff;
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