<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LocalBeats</title>
  <link rel='stylesheet' href='{{url("css/welcome.css")}}'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <nav class="navbar">
    <div class="logo"><img class="logo-img" src="{{ asset('images/logo.webp') }}" alt="LocalBeats Logo">  LocalBeats</div>
    
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">Musicians</a></li>
      <li><a href="#">Events</a></li>
      <li><a href="#">About</a></li>
    </ul>
    <div class="auth-buttons">
        <button id="loginBtn" class="login-btn">Log In</button>
        <button id="signupBtn" class="signup-btn">Sign Up</button>
    </div>

  </nav>

  <div id="popupOverlay" style="display: none;">
  <div class="popup">
    <span id="closePopup" class="close-btn">&times;</span>
    <div class="tabs">
      <button id="userTab" class="active">User</button>
      <button id="musicianTab">Musician</button>
    </div>
    <h2 id="formTitle">User Login</h2>
    <form>
      <input type="email" placeholder="Email" required>
      <input type="password" placeholder="Password" required>
      
      <div id="signupFields" style="display: none;">
        <input type="text" placeholder="Username">
        <input type="text" placeholder="Phone">
      </div>

      <button type="submit" class="submit-btn">Login</button>
      <p><a href="#" id="switchMode">Sign Up</a></p>
    </form>
  </div>
</div>


  <header class="hero">
    <h1>Connect with Local Musicians</h1>
    <p>Discover talented artists in your area, attend local events, and explore unique albums from independent musicians.</p>
    <div class="hero-buttons">
      <button class="find-btn">Find Musicians</button>
      <button class="secondary-btn">Learn More</button>
    </div>
  </header>

  <section class="featured-music-section">
    <h2 class="section-title">Featured Musicians</h2>
    <div class="music-grid">
    @foreach($featuredMusic as $music)
        <div class="music-card">
        <img src="{{ asset($music->image) }}" alt="Cover for {{ $music->artist_name }}" />

        <p>Genre: {{ $music->genre }}</p> {{-- fixed typo from genr to genre --}}
        <p>Rating: {{ $music->ratings }}/5</p> {{-- fixed rating field from rating to ratings --}}

        <audio controls>
        <source src="{{ asset($music->song_path) }}" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
        </div>
    @endforeach
    </div>
    </section>

    <section class="Upcoming-events">
        <h2 class="section-title">Upcoming Events</h2>
        <div class="event-grid">
        @foreach($upcomingEvents as $event)
            <div class="event-card">
                <img src="{{ asset($event->image) }}" alt="Event Image" />
                <h3>{{ $event->name }}</h3>                
                <p><i class="fas fa-calendar-alt"></i> {{ $event->date }}</p>
                <p><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                <p><i class="fas fa-clock"></i> {{ $event->time }}</p>
                <p><i class="fas fa-dollar-sign"></i> {{ $event->price }}</p>
                <button class="event-btn" >Book Tickets</button>
            </div>
        @endforeach
        </div>
    </section>

    <div class="community-section">
        <h2>Join Our Community</h2>
        <p>Are you a musician looking to connect with fans? Or a music lover wanting to discover local talent?</p>
        <button>Sign Up for Free</button>
    </div>

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

