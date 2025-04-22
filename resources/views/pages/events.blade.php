@extends('layouts.app')

@section('content')
<div class="events-container">
    <div class="events-header">
        <h1>My Events</h1>
        <p>Manage and view your upcoming performances</p>
    </div>

    @if(session()->has('user_id'))
        @if($events->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h2>No Events Yet</h2>
                <p>{{ $message }}</p>
                <button class="create-btn" id="createEventBtn">
                    <i class="fas fa-plus"></i> Create Event
                </button>
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                    <div class="event-card">
                        <div class="event-date">
                            <span class="day">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                            <span class="month">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                        </div>
                        <div class="event-details">
                            <h3>{{ $event->event_name }}</h3>
                            <p class="event-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue }}
                            </p>
                            <p class="event-time">
                                <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                            </p>
                            <p class="event-description">{{ $event->description }}</p>
                        </div>
                        <div class="event-actions">
                            <button class="action-btn edit-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn delete-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="create-btn" id="createEventBtn">
                <i class="fas fa-plus"></i> Create New Event
            </button>
        @endif
    @else
        <div class="login-prompt">
            <h2>Please Log In</h2>
            <p>You need to be logged in to view and manage your events.</p>
            <button class="login-btn" id="loginBtn">Log In</button>
        </div>
    @endif
</div>

<style>
    .events-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .events-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .events-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .events-header p {
        font-size: 1.2rem;
        color: #666;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 30px;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .event-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-5px);
    }

    .event-date {
        background: #2196f3;
        color: white;
        padding: 15px;
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
        padding: 20px;
    }

    .event-details h3 {
        font-size: 1.4rem;
        color: #333;
        margin-bottom: 15px;
    }

    .event-location, .event-time {
        color: #666;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .event-location i, .event-time i {
        margin-right: 10px;
        color: #2196f3;
    }

    .event-description {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-top: 15px;
    }

    .event-actions {
        padding: 15px 20px;
        background: #f9f9f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .action-btn {
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    .action-btn i {
        margin-right: 5px;
    }

    .edit-btn {
        background: #e3f2fd;
        color: #2196f3;
    }

    .delete-btn {
        background: #ffebee;
        color: #f44336;
    }

    .create-btn {
        display: block;
        width: 200px;
        margin: 30px auto;
        padding: 12px 20px;
        background: #2196f3;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .create-btn:hover {
        background: #1976d2;
    }

    .login-prompt {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .login-prompt h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 15px;
    }

    .login-prompt p {
        color: #666;
        margin-bottom: 30px;
    }

    .login-btn {
        padding: 12px 30px;
        background: #2196f3;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-btn:hover {
        background: #1976d2;
    }

    @media (max-width: 768px) {
        .events-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createEventBtn = document.getElementById('createEventBtn');
        if (createEventBtn) {
            createEventBtn.addEventListener('click', function() {
                // TODO: Implement event creation functionality
                alert('Event creation functionality coming soon!');
            });
        }

        const loginBtn = document.getElementById('loginBtn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function() {
                window.location.href = '/login';
            });
        }

        // Event action buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const eventId = this.dataset.eventId;
                // TODO: Implement event editing functionality
                alert('Event editing functionality coming soon!');
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const eventId = this.dataset.eventId;
                if (confirm('Are you sure you want to delete this event?')) {
                    // TODO: Implement event deletion functionality
                    alert('Event deletion functionality coming soon!');
                }
            });
        });
    });
</script>
@endsection 