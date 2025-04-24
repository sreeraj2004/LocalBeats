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
                @if($currentMusician && $currentMusician->profile_photo)
                    <img src="{{ asset('storage/' . $currentMusician->profile_photo) }}" alt="Profile Photo" class="profile-image" onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgNC44NCAyLjE3IDQuODQgNC44NCAwIDIuNjctMi4xNyA0Ljg0LTQuODQgNC44NC0yLjY3IDAtNC44NC0yLjE3LTQuODQtNC44NCAwLTIuNjcgMi4xNy00Ljg0IDQuODQtNC44NHptMCAxMmE5LjkxIDkuOTEgMCAwIDEtOC4xNi00LjQyYzAuMDQtLjExLjA5LS4yMS4xNS0uMzFDMi4yOSAxMyA0LjYxIDEzLjUgNyAxMy41YzIuNDkgMCA0LjgxLS41IDcuMTUtMS4yOS4wNi4xLjExLjIuMTUuMzFhOS45MSA5LjkxIDAgMCAxLTguMTYgNC40MnoiLz48L3N2Zz4=';">
                @else
                    <i class="fas fa-user-circle"></i>
                @endif
                <div class="avatar-overlay">
                    <label for="profile-photo-input" class="change-photo-btn">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" style="display: none;">
                </div>
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
                <button class="action-btn" onclick="window.location.href='/tests-event'">
                    <i class="fas fa-calendar"></i> My Events
                </button>
                <button class="action-btn" onclick="window.location.href='/tests-music'">
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
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto 1rem;
    background: #f0f0f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    padding: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-avatar:hover .avatar-overlay {
    opacity: 1;
}

.change-photo-btn {
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.change-photo-btn i {
    font-size: 1.2rem;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePhotoInput = document.getElementById('profile-photo-input');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function() {
            // Check if user is logged in
            if (!sessionStorage.getItem('userType')) {
                alert('Please log in to update your profile photo.');
                this.value = ''; // Clear the input
                window.location.href = '/login';
                return;
            }

            const file = this.files[0];
            
            // Validate file before uploading
            if (file) {
                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 2MB.');
                    this.value = ''; // Clear the input
                    return;
                }
                
                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload a JPEG, PNG, or GIF image.');
                    this.value = ''; // Clear the input
                    return;
                }

                const formData = new FormData();
                formData.append('profile_photo', file);
                
                // Show loading state
                const profileImage = document.querySelector('.profile-image');
                if (profileImage) {
                    profileImage.style.opacity = '0.5';
                }
                
                fetch('/update-profile-photo', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            try {
                                // Try to parse as JSON first
                                const json = JSON.parse(text);
                                throw new Error(json.message || 'Error updating profile photo');
                            } catch (e) {
                                // If not JSON, check specific error cases
                                if (response.status === 401) {
                                    // Unauthorized - need to log in again
                                    sessionStorage.clear();
                                    window.location.href = '/login';
                                    throw new Error('Please log in to update your profile photo.');
                                } else if (response.status === 419) {
                                    throw new Error('Session expired. Please refresh the page and try again.');
                                } else if (response.status === 413) {
                                    throw new Error('The file is too large. Maximum size is 2MB.');
                                } else if (response.status === 422) {
                                    throw new Error('Invalid file type. Please upload a JPEG, PNG, or GIF image.');
                                } else {
                                    console.error('Server response:', text);
                                    throw new Error('Server error. Please try again later.');
                                }
                            }
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update the profile image immediately
                        const profileImage = document.querySelector('.profile-image');
                        if (profileImage) {
                            profileImage.src = data.photo_url;
                            profileImage.style.opacity = '1';
                        }
                        alert('Profile photo updated successfully');
                    } else {
                        throw new Error(data.message || 'Error updating profile photo');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset loading state
                    const profileImage = document.querySelector('.profile-image');
                    if (profileImage) {
                        profileImage.style.opacity = '1';
                    }
                    alert(error.message || 'Error updating profile photo');
                })
                .finally(() => {
                    // Clear the input to allow uploading the same file again
                    this.value = '';
                });
            }
        });
    }
});
</script>
@endsection 