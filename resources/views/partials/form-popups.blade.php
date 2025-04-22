<!-- Event Form Popup -->
<div id="eventFormPopup" class="form-popup" data-popup="event">
    <div class="form-wrapper">
        <div class="form-container">
            <button class="close-btn">&times;</button>
            <h2>Add New Event</h2>
            <form id="eventForm" method="POST" action="/events" enctype="multipart/form-data" class="form-content">
                @csrf
                <div class="form-group">
                    <label for="title">Event Name</label>
                    <input type="text" id="title" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="date">Event Date</label>
                    <input type="date" id="date" name="date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="time">Event Time</label>
                    <input type="time" id="time" name="time" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Event Image</label>
                    <input type="file" id="image" name="image" class="form-file" accept="image/*" required>
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
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Music File</label>
                    <input type="file" id="file" name="file" class="form-file" accept="audio/*" required>
                </div>
                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-file" accept="image/*" required>
                </div>
                <button type="submit" class="submit-btn">Upload Music</button>
            </form>
        </div>
    </div>
</div> 