<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="logo"><img class="logo-img" src="{{ asset('images/logo.webp') }}" alt="LocalBeats Logo">  LocalBeats</div>
        
        <ul class="nav-links">
            <li><a href="{{ url('/home') }}" class="nav-link home-link">Home</a></li>
            <li><a href="{{ url('/musicians') }}" class="nav-link musicians-link">Musicians</a></li>
            @php
                $isMusician = false;
                if (session()->has('user_id')) {
                    $userId = session('user_id');
                    $musician = \App\Models\Musician::where('user_id', $userId)->first();
                    $isMusician = $musician ? true : false;
                }
            @endphp
            @if($isMusician)
                <li><a href="{{ url('/tests-event') }}" class="nav-link events-link">My Events</a></li>
                <li><a href="{{ url('/tests-music') }}" class="nav-link music-link">My Music</a></li>
            @else
                <li><a href="{{ url('/tests-events') }}" class="nav-link events-link">Events</a></li>
                <li><a href="{{ url('/tests-musics') }}" class="nav-link music-link">Music</a></li>
            @endif
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