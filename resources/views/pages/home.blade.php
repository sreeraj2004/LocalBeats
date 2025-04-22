@extends('layouts.app')

@section('content')
<div class="page-container">
    <h1>Welcome to Home</h1>
    <p>Discover the best local music and events in your area.</p>

    <div class="content-toggles">
        <button id="musicToggleBtn" class="toggle-btn">Show Music</button>
        <button id="eventToggleBtn" class="toggle-btn">Show Events</button>
    </div>

    <div id="musicSection" class="content-section" style="display: none;">
        <h2>Featured Music</h2>
        <div class="music-grid">
            <!-- Music items will be loaded here -->
        </div>
    </div>

    <div id="eventSection" class="content-section" style="display: none;">
        <h2>Upcoming Events</h2>
        <div class="event-grid">
            <!-- Event items will be loaded here -->
        </div>
    </div>

    @if(session()->has('user_id') && session('user_type') === 'Musician')
        <div class="action-buttons">
            <button id="addEventBtn" class="action-btn">Add Event</button>
            <button id="addMusicBtn" class="action-btn">Add Music</button>
        </div>
    @endif
</div>

<style>
.page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.content-toggles {
    display: flex;
    gap: 1rem;
    margin: 2rem 0;
}

.toggle-btn {
    padding: 0.8rem 1.5rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.toggle-btn:hover {
    background: #0056b3;
}

.content-section {
    margin: 2rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.music-grid, .event-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.action-btn {
    padding: 0.8rem 1.5rem;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.action-btn:hover {
    background: #218838;
}

/* Form Popup Styles */
.form-popup {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgba(0, 0, 0, 0.7) !important;
    backdrop-filter: blur(15px) !important;
    -webkit-backdrop-filter: blur(15px) !important;
    z-index: 1000 !important;
    display: none !important;
    justify-content: center !important;
    align-items: center !important;
    opacity: 0;
    visibility: hidden;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-popup.active,
.form-popup[style*="display: flex"] {
    display: flex !important;
    opacity: 1 !important;
    visibility: visible !important;
}

.form-wrapper {
    position: relative;
    width: 100%;
    max-width: 600px;
    padding: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 3rem;
    border-radius: 24px;
    width: 100%;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(-30px);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    border-radius: 24px 24px 0 0;
}

.form-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.form-container h2 {
    color: #2c3e50;
    margin-bottom: 2rem;
    font-size: 2.2rem;
    font-weight: 700;
    text-align: center;
    position: relative;
    padding-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-container h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    border-radius: 4px;
}

.form-group {
    margin-bottom: 0;
    position: relative;
}

.form-group label {
    display: block;
    margin-bottom: 0.8rem;
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.form-input,
.form-textarea,
.form-file {
    width: 100%;
    padding: 1.2rem 1.5rem;
    border: 2px solid rgba(224, 224, 224, 0.8);
    border-radius: 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(248, 249, 250, 0.9);
    color: #2c3e50;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.form-input:focus,
.form-textarea:focus,
.form-file:focus {
    border-color: #3498db;
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
    outline: none;
}

.form-textarea {
    min-height: 160px;
    resize: vertical;
    line-height: 1.6;
}

.form-file {
    padding: 1.2rem;
    background: rgba(248, 249, 250, 0.9);
    border: 2px dashed rgba(224, 224, 224, 0.8);
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-file:hover {
    border-color: #3498db;
    background: rgba(240, 247, 255, 0.9);
}

.submit-btn {
    width: 100%;
    padding: 1.4rem;
    background: linear-gradient(135deg, #3498db, #2ecc71);
    color: white;
    border: none;
    border-radius: 16px;
    cursor: pointer;
    font-size: 1.2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
}

.submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: 0.5s;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
}

.submit-btn:hover::before {
    left: 100%;
}

.close-btn {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: rgba(0, 0, 0, 0.1);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1001;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.close-btn:hover {
    background: rgba(0, 0, 0, 0.2);
    color: #333;
    transform: rotate(90deg);
}

/* Custom scrollbar for the form container */
.form-container::-webkit-scrollbar {
    width: 6px;
}

.form-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
}

.form-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #3498db, #2ecc71);
    border-radius: 3px;
}

.form-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2980b9, #27ae60);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Checking popup elements in inline script');
    console.log('Event Form Popup:', document.getElementById('eventFormPopup'));
    console.log('Music Form Popup:', document.getElementById('musicFormPopup'));
});
</script>
@endsection 