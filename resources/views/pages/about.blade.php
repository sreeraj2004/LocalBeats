@extends('layouts.app')

@section('content')
<div class="about-container">
    <div class="about-header">
        <h1>About LocalBeats</h1>
        <p>Connecting musicians and music lovers in your community</p>
    </div>

    @if(session()->has('user_id') && $currentMusician)
        <div class="profile-card">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h2>{{ $currentMusician->user->name }}</h2>
            <p class="musician-label">Musician</p>

            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="detail-text">
                        <span class="detail-label">Band Name</span>
                        <span class="detail-value">{{ $currentMusician->band_name }}</span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-guitar"></i>
                    </div>
                    <div class="detail-text">
                        <span class="detail-label">Genre</span>
                        <span class="detail-value">{{ $currentMusician->genre }}</span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="detail-text">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{ $currentMusician->user->email }}</span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="detail-text">
                        <span class="detail-label">Member Since</span>
                        <span class="detail-value">{{ $currentMusician->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <button class="action-btn" onclick="window.location.href='/edit-profile'">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <button class="action-btn" onclick="window.location.href='/events'">
                    <i class="fas fa-calendar"></i> My Events
                </button>
                <button class="action-btn" onclick="window.location.href='/music'">
                    <i class="fas fa-music"></i> My Music
                </button>
            </div>
        </div>
    @else
        <div class="login-prompt">
            <h2>Please Log In</h2>
            <p>You need to be logged in to view your profile.</p>
            <button class="login-btn" onclick="showPopup('login')">Log In</button>
        </div>
    @endif
</div>

<style>
.about-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.about-header {
    text-align: center;
    margin-bottom: 2rem;
}

.about-header h1 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.about-header p {
    font-size: 1.1rem;
    color: #666;
}

.profile-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 2rem;
    text-align: center;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto 1rem;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-avatar i {
    font-size: 3rem;
    color: #666;
}

.profile-card h2 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.musician-label {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.profile-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: left;
}

.detail-icon {
    width: 40px;
    height: 40px;
    background: #e3f2fd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.detail-icon i {
    font-size: 1.2rem;
    color: #007bff;
}

.detail-text {
    flex: 1;
}

.detail-label {
    display: block;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.detail-value {
    display: block;
    font-size: 1.1rem;
    color: #333;
    font-weight: 500;
}

.profile-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.8rem 1.5rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.action-btn i {
    margin-right: 0.5rem;
}

.action-btn:hover {
    background: #0056b3;
}

.login-prompt {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 10px;
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
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-btn:hover {
    background: #0056b3;
}
</style>
@endsection 