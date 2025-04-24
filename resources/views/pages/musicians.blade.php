@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Our Musicians</h1>
    
    <div class="musicians-grid">
        @foreach($musicians as $musician)
            <a href="{{ route('musician.details', $musician->id) }}" class="musician-card">
                <div class="musician-photo">
                    @if($musician->profile_photo)
                        <img src="{{ asset('storage/' . $musician->profile_photo) }}" alt="{{ $musician->user->name }}">
                    @else
                        <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile">
                    @endif
                </div>
                <div class="musician-info">
                    <h3>{{ $musician->user->name }}</h3>
                    <p class="band-name">{{ $musician->band_name }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
    font-size: 2.5em;
}

.musicians-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    padding: 20px;
}

.musician-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.musician-card:hover {
    transform: translateY(-5px);
}

.musician-photo {
    width: 100%;
    height: 250px;
    overflow: hidden;
}

.musician-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.musician-card:hover .musician-photo img {
    transform: scale(1.05);
}

.musician-info {
    padding: 20px;
    text-align: center;
}

.musician-info h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.2em;
}

.band-name {
    color: #666;
    margin: 0;
    font-size: 1em;
}
</style>
@endsection 