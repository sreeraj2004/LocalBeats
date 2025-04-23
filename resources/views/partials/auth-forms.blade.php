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
            @csrf
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