@extends('layouts.app')

@section('content')
<div class="music-container">
    <div class="music-header">
        <h1>My Music</h1>
        <p>Manage and share your musical creations</p>
    </div>

    @if(session()->has('user_id'))
        @if($music->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h2>No Music Yet</h2>
                <p>{{ $message }}</p>
                <button class="create-btn" id="createMusicBtn">
                    <i class="fas fa-plus"></i> Share Music
                </button>
            </div>
        @else
            <div class="music-grid">
                @foreach($music as $track)
                    <div class="music-card">
                        <div class="music-cover">
                            @if($track->cover_image)
                                <img src="{{ asset('storage/' . $track->cover_image) }}" alt="{{ $track->title }}">
                            @else
                                <div class="default-cover">
                                    <i class="fas fa-music"></i>
                                </div>
                            @endif
                        </div>
                        <div class="music-details">
                            <h3>{{ $track->title }}</h3>
                            <p class="music-artist">
                                <i class="fas fa-user"></i> {{ $track->artist_name }}
                            </p>
                            <p class="music-genre">
                                <i class="fas fa-tag"></i> {{ $track->genre }}
                            </p>
                            <div class="music-player">
                                <audio controls>
                                    <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                        <div class="music-actions">
                            <button class="action-btn edit-btn" data-music-id="{{ $track->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn delete-btn" data-music-id="{{ $track->id }}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="create-btn" id="createMusicBtn">
                <i class="fas fa-plus"></i> Share New Music
            </button>
        @endif
    @else
        <div class="login-prompt">
            <h2>Please Log In</h2>
            <p>You need to be logged in to view and manage your music.</p>
            <button class="login-btn" id="loginBtn">Log In</button>
        </div>
    @endif
</div>

<style>
    .music-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .music-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .music-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .music-header p {
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

    .music-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .music-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .music-card:hover {
        transform: translateY(-5px);
    }

    .music-cover {
        height: 200px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .music-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .default-cover {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e3f2fd;
        color: #2196f3;
        font-size: 4rem;
    }

    .music-details {
        padding: 20px;
    }

    .music-details h3 {
        font-size: 1.4rem;
        color: #333;
        margin-bottom: 15px;
    }

    .music-artist, .music-genre {
        color: #666;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .music-artist i, .music-genre i {
        margin-right: 10px;
        color: #2196f3;
    }

    .music-player {
        margin-top: 15px;
    }

    .music-player audio {
        width: 100%;
        height: 36px;
    }

    .music-actions {
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
        .music-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createMusicBtn = document.getElementById('createMusicBtn');
        if (createMusicBtn) {
            createMusicBtn.addEventListener('click', function() {
                // TODO: Implement music sharing functionality
                alert('Music sharing functionality coming soon!');
            });
        }

        const loginBtn = document.getElementById('loginBtn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function() {
                window.location.href = '/login';
            });
        }

        // Music action buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const musicId = this.dataset.musicId;
                // TODO: Implement music editing functionality
                alert('Music editing functionality coming soon!');
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const musicId = this.dataset.musicId;
                if (confirm('Are you sure you want to delete this track?')) {
                    // TODO: Implement music deletion functionality
                    alert('Music deletion functionality coming soon!');
                }
            });
        });
    });
</script>
@endsection 