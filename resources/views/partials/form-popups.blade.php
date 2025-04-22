<!-- Event Form Popup -->
<div id="eventFormPopup" class="form-popup" data-popup="event">
    <div class="form-wrapper">
        <div class="form-container">
            <button class="close-btn">&times;</button>
            <h2>Add New Event</h2>
            <form id="eventForm" method="POST" action="/upload-event" enctype="multipart/form-data" class="form-content">
                @csrf
                <div class="form-group">
                    <label for="eventTitle">Event Name</label>
                    <input type="text" id="eventTitle" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="eventDate">Event Date</label>
                    <input type="date" id="eventDate" name="date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="eventTime">Event Time</label>
                    <input type="time" id="eventTime" name="time" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="eventLocation">Location</label>
                    <input type="text" id="eventLocation" name="location" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="eventPrice">Price</label>
                    <input type="number" id="eventPrice" name="price" class="form-input" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="eventImage">Event Image</label>
                    <input type="file" id="eventImage" name="image" class="form-file" accept="image/*" required>
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
                    <label for="musicTitle">Title</label>
                    <input type="text" id="musicTitle" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="musicGenre">Genre</label>
                    <input type="text" id="musicGenre" name="genre" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="musicDescription">Description</label>
                    <textarea id="musicDescription" name="description" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="musicFile">Music File</label>
                    <input type="file" id="musicFile" name="file" class="form-file" accept="audio/*" required>
                </div>
                <div class="form-group">
                    <label for="musicCoverImage">Cover Image</label>
                    <input type="file" id="musicCoverImage" name="cover_image" class="form-file" accept="image/*" required>
                </div>
                <button type="submit" class="submit-btn">Upload Music</button>
            </form>
        </div>
    </div>
</div> 