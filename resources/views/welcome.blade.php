<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>LocalBeats</title>
  <link rel='stylesheet' href='{{url("css/welcome.css")}}'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- navbar -->
  <nav class="navbar">
    <div class="logo"><img class="logo-img" src="{{ asset('images/logo.webp') }}" alt="LocalBeats Logo">  LocalBeats</div>
    
    <ul class="nav-links">
      <li><a href="{{ url('/home') }}" class="nav-link home-link">Home</a></li>
      <li><a href="{{ url('/musicians') }}" class="nav-link musicians-link">Musicians</a></li>
      <li><a href="{{ url('/tests-events') }}" class="nav-link events-link">Events</a></li>
      <li><a href="{{ url('/tests-musics') }}" class="nav-link music-link">Music</a></li>
      <li><a href="{{ url('/about') }}" class="nav-link about-link">About</a></li>
    </ul>
    <div class="auth-buttons">
        <button id="loginBtn" class="login-btn">Log In</button>
        <button id="signupBtn" class="signup-btn">Sign Up</button>
        <button id="dashboardBtn" class="dashboard-btn" style="display: none;">Dashboard</button>
        <button id="navLogoutBtn" class="logout-btn" style="display: none;">Logout</button>
    </div>

  </nav>

  <!-- login and signup -->
  <div id="popupOverlay" class="popup-overlay">
    <div class="popup-form">
        <span id="closePopup" class="close-btn">&times;</span>
        <div class="form-toggle">
            <button id="userTab" class="active">User</button>
            <button id="musicianTab">Musician</button>
        </div>
        <h2 id="formTitle">User Login</h2>
        <form id="authForm" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="text" id="nameField" name="name" placeholder="Name" style="display: none;">
            <input type="email" id="emailField" name="email" placeholder="Email" required>

            <div id="musicianFields" style="display: none;">
                <input type="text" id="bandNameField" name="band_name" placeholder="Band Name">
                <input type="text" id="genreField" name="genre" placeholder="Genre">
            </div>

            <input type="password" id="passwordField" name="password" placeholder="Password" required>
            <input type="password" id="confirmPasswordField" name="password_confirmation" placeholder="Confirm Password" style="display: none;">

            <button type="submit" class="submit-btn">Login</button>
            <p class="toggle-link"><a href="#" id="switchMode">Sign Up</a></p>
        </form>

        </div>
    </div>

    
    <!-- dashboard -->
    <div id="dashboardPanel">
        <button id="closeDashboard">✖</button>
        <p>Welcome</p>

        <!-- New Buttons -->
        <button id="addEventBtn" style="display: none;" class="dashboard-btn"><span style="margin-right: 8px;">🎉</span>Add Event   </button>
        <button id="addMusicBtn" style="display: none;" class="dashboard-btn"><span style="margin-right: 8px;">🎵</span>Add Music</button>

        <button id="dashboardLogoutBtn">Logout</button>
    </div>

     
    <!-- Add Event Form Popup -->
    <div id="eventFormPopup" class="unique-popup-overlay">
        <div class="unique-popup-form">
            <span class="unique-close-btn" onclick="document.getElementById('eventFormPopup').style.display='none'">&times;</span>
            <h2>Add Event</h2>
            @csrf
            <form id="eventForm" class="unique-popup-form" enctype="multipart/form-data" method="POST" action="/upload-event">
                <input type="file" accept="image/*" name="image" required />
                <input type="text" placeholder="Event Name" name="name" required />
                <input type="date" name="date" required />
                <input type="text" placeholder="Location" name="location" required />
                <input type="time" name="time" required />
                <input type="number" placeholder="Price" name="price" required />
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Add Music Form Popup -->
    <div id="musicFormPopup" class="unique-popup-overlay">
        <div class="unique-popup-form">
            <span class="unique-close-btn" onclick="document.getElementById('musicFormPopup').style.display='none'">&times;</span>
            <h2>Add Music</h2>
            <form id="musicForm" class="unique-popup-form" enctype="multipart/form-data" method="POST" action="/upload-music">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Title" name="title" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Genre" name="genre" required />
                </div>
                <div class="form-group">
                    <label for="musicFile">Select Music File (MP3 or WAV)</label>
                    <input type="file" class="form-control" id="musicFile" name="file" accept="audio/mp3,audio/wav" required />
                </div>
                <div class="form-group">
                    <label for="musicCoverImage">Cover Image (Optional)</label>
                    <input type="file" class="form-control" id="musicCoverImage" name="cover_image" accept="image/*" />
                </div>
                <button type="submit" class="submit-btn">Upload Music</button>
            </form>
        </div>
    </div>


    <!-- hero section -->
  <header class="hero">
    <h1>Connect with Local Musicians</h1>
    <p>Discover talented artists in your area, attend local events, and explore unique albums from independent musicians.</p>
  </header>

  <section class="featured-music-section">
    <h2 class="section-title">Featured Musicians</h2>
    <div class="music-grid">
    @foreach($music as $track)
        <div class="music-card">
            @if($track->image)
                <img src="{{ asset('storage/' . $track->image) }}" alt="{{ $track->artist_name }}" class="music-cover">
            @else
                <img src="{{ asset('images/default-music-cover.jpg') }}" alt="Default Cover" class="music-cover">
            @endif
            <h3>{{ $track->artist_name }}</h3>
            <p>By: {{ $track->musician->user->name }}</p>
            <p>Genre: {{ $track->genre }}</p>
            <audio controls>
                <source src="{{ asset('storage/' . $track->song_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    @endforeach
    </div>
    @if(count($music) > 3)
    <p class="toggle-btn" id="musicToggleBtn" style="color: blue; text-align: center; cursor: pointer; margin-top: 20px;">Show More</p>
    @endif
    </section>

    <!-- upcoming events -->
    <section class="Upcoming-events">
        <h2 class="section-title">Upcoming Events</h2>
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
                    <p>By: {{ $event->musician->user->name }}</p>
                    <p>Date: {{ $event->date->format('M d, Y') }}</p>
                    <p>Time: {{ $event->time }}</p>
                    <p>Location: {{ $event->location }}</p>
                    <p>Price: ${{ number_format($event->price, 2) }}</p>
                    <button class="book-event-btn" onclick="bookEvent({{ $event->id }})">
                        <i class="fas fa-ticket-alt"></i> Book Event
                    </button>
                </div>
            </div>
        @endforeach
        </div>
        @if(count($events) > 3)
        <p class="toggle-btn" id="eventToggleBtn" style="color: blue; text-align: center; cursor: pointer; margin-top: 20px;">Show More</p>
        @endif
    </section>

    <!-- community section -->
    <div class="community-section">
        <h2>Join Our Community</h2>
        <p>Are you a musician looking to connect with fans? Or a music lover wanting to discover local talent?</p>
        <button id="communitySignupBtn">Sign Up for Free</button>
    </div>

    <!-- footer -->
    <footer class="footer">
        <div class="footer-logo">
            <div class="logo-container"><img class="logo-img" src="{{ asset('images/logo.webp') }}" alt="LocalBeats Logo"><h2>LocalBeats</h2></div>
            <p>Connect with local musicians, attend live events, and explore new music in your area.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f" style="font-size: 20px;"></i></a>
                <a href="#"><i class="fab fa-twitter" style="font-size: 20px;"></i></a>
                <a href="#"><i class="fab fa-instagram" style="font-size: 20px;"></i></a>
                <a href="#"><i class="fab fa-linkedin-in" style="font-size: 20px;"></i></a>
            </div>
        </div>
        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Musicians</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </div>
        <div class="footer-support">
            <h3>Support</h3>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-subscribe">
            <h3>Subscribe</h3>
            <p>Stay updated with the latest events and news.</p>
            <input type="email" placeholder="Your email address">
            <button>Subscribe</button>
        </div>
    </footer>

    <div class="footer-bottom">
        <p>&copy; 2025 LocalBeats. All rights reserved. | <a href="#">Credits</a></p>
    </div>
    <script src="{{ asset('js/home.js')}}" type="text/javascript"></script>
</body>
</html>

<style>
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

.event-details {
    padding: 20px;
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

