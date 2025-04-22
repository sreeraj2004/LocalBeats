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
            <li><a href="{{ url('/events') }}" class="nav-link events-link">Events</a></li>
            <li><a href="{{ url('/music') }}" class="nav-link music-link">Music</a></li>
            <li><a href="{{ url('/about') }}" class="nav-link about-link">About</a></li>
        </ul>
        <div class="auth-buttons">
            <button id="loginBtn" class="login-btn">Log In</button>
            <button id="signupBtn" class="signup-btn">Sign Up</button>
            <button id="dashboardBtn" class="dashboard-btn" style="display: none;">Dashboard</button>
            <button id="navLogoutBtn" class="logout-btn" style="display: none;">Logout</button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Include the popup forms and dashboard panel from welcome.blade.php -->
    @include('partials.auth-forms')
    @include('partials.dashboard-panel')
    @include('partials.form-popups')

    <script src="{{ asset('js/home.js')}}" type="text/javascript"></script>
</body>
</html> 