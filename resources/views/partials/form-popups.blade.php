<!-- Event Form Popup -->
<div id="eventFormPopup" class="form-popup" data-popup="event">
    <div class="form-wrapper">
        <div class="form-container">
            <button class="close-btn">&times;</button>
            <h2>Add New Event</h2>
            <form id="eventForm" method="POST" action="/events" enctype="multipart/form-data" class="form-content">
                @csrf
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date</label>
                    <input type="datetime-local" id="event_date" name="event_date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="event_location">Location</label>
                    <input type="text" id="event_location" name="event_location" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="event_description">Description</label>
                    <textarea id="event_description" name="event_description" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="event_image">Event Image</label>
                    <input type="file" id="event_image" name="event_image" class="form-file" accept="image/*">
                </div>
                <button type="submit" class="submit-btn">Create Event</button>
            </form>
        </div>
    </div>
</div>

<!-- Music Form Popup -->
<div id="musicFormPopup" class="form-popup" data-popup="music">
    <div class="form-wrapper">
        <div class="form-container">
            <button class="close-btn">&times;</button>
            <h2>Add New Music</h2>
            <form id="musicForm" method="POST" action="/music" enctype="multipart/form-data" class="form-content">
                @csrf
                <div class="form-group">
                    <label for="music_title">Title</label>
                    <input type="text" id="music_title" name="music_title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="music_genre">Genre</label>
                    <input type="text" id="music_genre" name="music_genre" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="music_description">Description</label>
                    <textarea id="music_description" name="music_description" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="music_file">Music File</label>
                    <input type="file" id="music_file" name="music_file" class="form-file" accept="audio/*" required>
                </div>
                <div class="form-group">
                    <label for="music_cover">Cover Image</label>
                    <input type="file" id="music_cover" name="music_cover" class="form-file" accept="image/*">
                </div>
                <button type="submit" class="submit-btn">Upload Music</button>
            </form>
        </div>
    </div>
</div> 