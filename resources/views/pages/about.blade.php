@extends('layouts.app')

@section('content')
<div class="about-container">
    <div class="about-header">
        <h1>About LocalBeats</h1>
        <p>Connecting musicians and music lovers in your community</p>
    </div>

    @if(session()->has('user_id') && $currentMusician)
        <div class="musician-profile">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h2>{{ $currentMusician->user->name }}</h2>
                <p class="musician-title">Musician</p>
            </div>
            
            <div class="profile-details">
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="detail-content">
                        <h3>Band Name</h3>
                        <p>{{ $currentMusician->band_name }}</p>
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-guitar"></i>
                    </div>
                    <div class="detail-content">
                        <h3>Genre</h3>
                        <p>{{ $currentMusician->genre }}</p>
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="detail-content">
                        <h3>Email</h3>
                        <p>{{ $currentMusician->user->email }}</p>
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="detail-content">
                        <h3>Member Since</h3>
                        <p>{{ $currentMusician->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="profile-actions">
                <button class="action-btn" id="editProfileBtn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
                <button class="action-btn" id="viewEventsBtn">
                    <i class="fas fa-calendar"></i> My Events
                </button>
                <button class="action-btn" id="viewMusicBtn">
                    <i class="fas fa-music"></i> My Music
                </button>
            </div>
        </div>
    @else
        <div class="about-content">
            <div class="about-section">
                <h2>Our Mission</h2>
                <p>LocalBeats is dedicated to connecting local musicians with music enthusiasts in your community. We provide a platform for musicians to showcase their talent, promote events, and share their music with a wider audience.</p>
            </div>
            
            <div class="about-section">
                <h2>What We Offer</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <i class="fas fa-music"></i>
                        <h3>Music Discovery</h3>
                        <p>Explore and discover talented local musicians and their music.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Event Management</h3>
                        <p>Find and book tickets for upcoming music events in your area.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-users"></i>
                        <h3>Community</h3>
                        <p>Connect with fellow music lovers and musicians in your community.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-star"></i>
                        <h3>Support Local Artists</h3>
                        <p>Support and promote local talent in your area.</p>
                    </div>
                </div>
            </div>
            
            <div class="about-section">
                <h2>Join Our Community</h2>
                <p>Whether you're a musician looking to connect with fans or a music lover wanting to discover local talent, LocalBeats is the platform for you. Sign up today and become part of our growing community!</p>
                <button id="joinCommunityBtn" class="join-btn">Join Now</button>
            </div>
        </div>
    @endif
</div>

<style>
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .about-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .about-header h1 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 10px;
    }
    
    .about-header p {
        font-size: 1.2rem;
        color: #666;
    }
    
    /* Musician Profile Styles */
    .musician-profile {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 40px;
    }
    
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        background-color: #f0f0f0;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .profile-avatar i {
        font-size: 80px;
        color: #666;
    }
    
    .profile-header h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 5px;
    }
    
    .musician-title {
        font-size: 1.1rem;
        color: #666;
        font-style: italic;
    }
    
    .profile-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .detail-card {
        display: flex;
        align-items: center;
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        transition: transform 0.3s ease;
    }
    
    .detail-card:hover {
        transform: translateY(-5px);
    }
    
    .detail-icon {
        width: 50px;
        height: 50px;
        background-color: #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .detail-icon i {
        font-size: 20px;
        color: #333;
    }
    
    .detail-content h3 {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }
    
    .detail-content p {
        font-size: 1.1rem;
        color: #333;
        font-weight: 500;
    }
    
    .profile-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 10px 20px;
        background-color: #f0f0f0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        transition: background-color 0.3s ease;
    }
    
    .action-btn i {
        margin-right: 8px;
    }
    
    .action-btn:hover {
        background-color: #e0e0e0;
    }
    
    /* About Content Styles */
    .about-content {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }
    
    .about-section {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .about-section h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .about-section p {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .feature-card {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
    }
    
    .feature-card i {
        font-size: 2rem;
        color: #333;
        margin-bottom: 15px;
    }
    
    .feature-card h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
    }
    
    .feature-card p {
        font-size: 1rem;
        color: #666;
    }
    
    .join-btn {
        display: block;
        width: 200px;
        margin: 20px auto 0;
        padding: 12px 20px;
        background-color: #2196f3;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .join-btn:hover {
        background-color: #0b7dda;
    }
    
    @media (max-width: 768px) {
        .profile-details {
            grid-template-columns: 1fr;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Join Community Button
        const joinCommunityBtn = document.getElementById('joinCommunityBtn');
        if (joinCommunityBtn) {
            joinCommunityBtn.addEventListener('click', function() {
                const signupBtn = document.getElementById('signupBtn');
                if (signupBtn) {
                    signupBtn.click();
                }
            });
        }
        
        // Profile Action Buttons
        const editProfileBtn = document.getElementById('editProfileBtn');
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function() {
                alert('Edit profile functionality coming soon!');
            });
        }
        
        const viewEventsBtn = document.getElementById('viewEventsBtn');
        if (viewEventsBtn) {
            viewEventsBtn.addEventListener('click', function() {
                window.location.href = '/events';
            });
        }
        
        const viewMusicBtn = document.getElementById('viewMusicBtn');
        if (viewMusicBtn) {
            viewMusicBtn.addEventListener('click', function() {
                window.location.href = '/music';
            });
        }
    });
</script>
@endsection 