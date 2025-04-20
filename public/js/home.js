document.addEventListener('DOMContentLoaded', function () {
  const loginBtn = document.getElementById('loginBtn');
  const signupBtn = document.getElementById('signupBtn');
  const popupOverlay = document.getElementById('popupOverlay');
  const closePopup = document.getElementById('closePopup');
  const formTitle = document.getElementById('formTitle');
  const submitBtn = document.querySelector('.submit-btn');
  const switchMode = document.getElementById('switchMode');
  const userTab = document.getElementById('userTab');
  const musicianTab = document.getElementById('musicianTab');

  const nameField = document.getElementById('nameField');
  const emailField = document.getElementById('emailField');
  const bandNameField = document.getElementById('bandNameField');
  const genreField = document.getElementById('genreField');
  const passwordField = document.getElementById('passwordField');
  const confirmPasswordField = document.getElementById('confirmPasswordField');
  const musicianFields = document.getElementById('musicianFields');
  const form = document.getElementById('authForm');

  const dashboardBtn = document.getElementById('dashboardBtn');
  const dashboardPanel = document.getElementById('dashboardPanel');
  const closeDashboard = document.getElementById('closeDashboard');
  const logoutBtn = document.getElementById('logoutBtn');
  const addEventBtn = document.getElementById('addEventBtn');
  const addMusicBtn = document.getElementById('addMusicBtn');

  const eventForm = document.getElementById('eventForm');
  const musicForm = document.getElementById('musicForm');

  const eventFormPopup = document.getElementById('eventFormPopup');
  const musicFormPopup = document.getElementById('musicFormPopup');

  let currentMode = 'login';
  let currentType = 'User';

  function showPopup(mode) {
    currentMode = mode;
    popupOverlay.style.display = 'flex';
    updateForm();
  }

  function updateForm() {
    formTitle.innerText = `${currentType} ${currentMode === 'login' ? 'Login' : 'Sign Up'}`;
    submitBtn.innerText = currentMode === 'login' ? 'Login' : 'Sign Up';
    switchMode.innerText = currentMode === 'login' ? 'Sign Up' : 'Login';

    nameField.style.display = currentMode === 'signup' ? 'block' : 'none';
    confirmPasswordField.style.display = currentMode === 'signup' ? 'block' : 'none';

    musicianFields.style.display = (currentMode === 'signup' && currentType === 'Musician') ? 'block' : 'none';
  }

  loginBtn.onclick = () => showPopup('login');
  signupBtn.onclick = () => showPopup('signup');
  
  // Fix for close button functionality
  if (closePopup) {
    closePopup.addEventListener('click', function() {
      popupOverlay.style.display = 'none';
    });
  } else {
    console.error('Close button element not found');
  }
  
  // Also add click event on the overlay to close when clicking outside the form
  popupOverlay.addEventListener('click', function(e) {
    if (e.target === popupOverlay) {
      popupOverlay.style.display = 'none';
    }
  });

  switchMode.onclick = (e) => {
    e.preventDefault();
    currentMode = currentMode === 'login' ? 'signup' : 'login';
    updateForm();
  };

  userTab.onclick = () => {
    currentType = 'User';
    userTab.classList.add('active');
    musicianTab.classList.remove('active');
    updateForm();
  };

  musicianTab.onclick = () => {
    currentType = 'Musician';
    musicianTab.classList.add('active');
    userTab.classList.remove('active');
    updateForm();
  };

  submitBtn.addEventListener('click', function (e) {
    e.preventDefault();

    if (currentMode === 'signup' && passwordField.value !== confirmPasswordField.value) {
      alert('The password confirmation does not match.');
      return;
    }

    if (currentMode === 'signup' && currentType === 'User') {
      form.action = '/register/user';
    } else if (currentMode === 'signup' && currentType === 'Musician') {
      form.action = '/register/musician';
    } else if (currentMode === 'login' && currentType === 'User') {
      form.action = '/login/user';
    } else if (currentMode === 'login' && currentType === 'Musician') {
      form.action = '/login/musician';
    }

    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
      .then(response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
          throw new Error('Server returned non-JSON response. Please try again or contact support.');
        }
        if (!response.ok) {
          return response.json().then(data => {
            throw new Error(data.error || 'Network response was not ok');
          });
        }
        return response.json();
      })
      .then(data => {
        if (data.errors || data.error) {
          alert(Object.values(data.errors || data.error).flat().join('\n'));
        } else {
          alert(data.message || 'Form submitted successfully!');
          popupOverlay.style.display = 'none';
          form.reset();

          loginBtn.style.display = 'none';
          signupBtn.style.display = 'none';
          dashboardBtn.style.display = 'inline-block';

          sessionStorage.setItem('userType', currentType);
          sessionStorage.setItem('userName', data.user?.name || '');
          if (data.isMusician) {
            sessionStorage.setItem('musicianId', data.musician?.id || '');
            addEventBtn.style.display = 'block';
            addMusicBtn.style.display = 'block';
          } else {
            addEventBtn.style.display = 'none';
            addMusicBtn.style.display = 'none';
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the form: ' + error.message);
      });
  });

  dashboardBtn.onclick = () => {
    dashboardPanel.classList.add('active');

    const storedType = sessionStorage.getItem('userType');
    if (storedType === 'Musician') {
      addEventBtn.style.display = 'block';
      addMusicBtn.style.display = 'block';
    } else {
      addEventBtn.style.display = 'none';
      addMusicBtn.style.display = 'none';
    }
  };

  closeDashboard.onclick = () => {
    dashboardPanel.classList.remove('active');
  };

  logoutBtn.onclick = () => {
    dashboardPanel.classList.remove('active');
    dashboardBtn.style.display = 'none';
    loginBtn.style.display = 'inline-block';
    signupBtn.style.display = 'inline-block';
    sessionStorage.clear();
    alert('You have been logged out.');
  };

  addEventBtn.onclick = () => {
    document.body.classList.add('blurred');
    eventFormPopup.style.display = 'flex';
    musicFormPopup.style.display = 'none';
  };

  addMusicBtn.onclick = () => {
    document.body.classList.add('blurred');
    musicFormPopup.style.display = 'flex';
    eventFormPopup.style.display = 'none';
  };

  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.onclick = () => {
      eventFormPopup.style.display = 'none';
      musicFormPopup.style.display = 'none';
      document.body.classList.remove('blurred');
    };
  });

  window.addEventListener('click', (e) => {
    if (e.target === eventFormPopup || e.target === musicFormPopup) {
      eventFormPopup.style.display = 'none';
      musicFormPopup.style.display = 'none';
      document.body.classList.remove('blurred');
    }
  });

  // Add event listeners for music and event forms
  if (musicForm) {
    musicForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(musicForm);
      
      // Log form data for debugging
      console.log('Submitting music form with data:');
      for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
      }
      
      fetch('/upload-music', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
      .then(response => {
        console.log('Response status:', response.status);
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
          throw new Error('Server returned non-JSON response. Please try again or contact support.');
        }
        if (!response.ok) {
          return response.json().then(data => {
            throw new Error(data.message || 'Network response was not ok');
          });
        }
        return response.json();
      })
      .then(data => {
        console.log('Success response:', data);
        if (data.success) {
          alert('Music uploaded successfully!');
          musicFormPopup.style.display = 'none';
          document.body.classList.remove('blurred');
          musicForm.reset();
          // Optionally refresh the page to show the new music
          window.location.reload();
        } else {
          throw new Error(data.message || 'Upload failed');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('There was an error uploading the music: ' + error.message);
      });
    });
  }

  if (eventForm) {
    eventForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(eventForm);
      
      // Log form data for debugging
      console.log('Submitting event form with data:');
      for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
      }
      
      fetch('/upload-event', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
      .then(response => {
        console.log('Response status:', response.status);
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
          throw new Error('Server returned non-JSON response. Please try again or contact support.');
        }
        if (!response.ok) {
          return response.json().then(data => {
            throw new Error(data.message || 'Network response was not ok');
          });
        }
        return response.json();
      })
      .then(data => {
        console.log('Success response:', data);
        if (data.success) {
          alert('Event added successfully!');
          eventFormPopup.style.display = 'none';
          document.body.classList.remove('blurred');
          eventForm.reset();
          // Optionally refresh the page to show the new event
          window.location.reload();
        } else {
          throw new Error(data.message || 'Upload failed');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('There was an error adding the event: ' + error.message);
      });
    });
  }
});

// Show More/Show Less functionality - moved outside the nested DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing Show More/Less functionality');
  
  // Music toggle functionality
  const musicToggleBtn = document.getElementById('musicToggleBtn');
  if (musicToggleBtn) {
    console.log('Music toggle button found');
    musicToggleBtn.addEventListener('click', function() {
      console.log('Music toggle button clicked');
      const hiddenMusicItems = document.querySelectorAll('.music-card.hidden-item');
      if (hiddenMusicItems.length > 0) {
        // Show all items
        hiddenMusicItems.forEach(item => {
          item.classList.remove('hidden-item');
        });
        musicToggleBtn.textContent = 'Show Less';
      } else {
        // Hide items beyond the first 3
        const musicCards = document.querySelectorAll('.music-card');
        musicCards.forEach((item, index) => {
          if (index >= 3) {
            item.classList.add('hidden-item');
          }
        });
        musicToggleBtn.textContent = 'Show More';
      }
    });
  } else {
    console.log('Music toggle button not found');
  }

  // Event toggle functionality
  const eventToggleBtn = document.getElementById('eventToggleBtn');
  if (eventToggleBtn) {
    console.log('Event toggle button found');
    eventToggleBtn.addEventListener('click', function() {
      console.log('Event toggle button clicked');
      const hiddenEventItems = document.querySelectorAll('.event-card.hidden-item');
      if (hiddenEventItems.length > 0) {
        // Show all items
        hiddenEventItems.forEach(item => {
          item.classList.remove('hidden-item');
        });
        eventToggleBtn.textContent = 'Show Less';
      } else {
        // Hide items beyond the first 3
        const eventCards = document.querySelectorAll('.event-card');
        eventCards.forEach((item, index) => {
          if (index >= 3) {
            item.classList.add('hidden-item');
          }
        });
        eventToggleBtn.textContent = 'Show More';
      }
    });
  } else {
    console.log('Event toggle button not found');
  }
  
  // Single audio player functionality
  let currentlyPlayingAudio = null;
  
  // Get all audio elements on the page
  const allAudioElements = document.querySelectorAll('audio');
  
  // Add event listeners to all audio elements
  allAudioElements.forEach(audio => {
    // When play is clicked
    audio.addEventListener('play', function() {
      // If there's already an audio playing and it's not this one
      if (currentlyPlayingAudio && currentlyPlayingAudio !== audio) {
        // Pause the currently playing audio
        currentlyPlayingAudio.pause();
        currentlyPlayingAudio.currentTime = 0;
      }
      
      // Set this audio as the currently playing one
      currentlyPlayingAudio = audio;
    });
    
    // When audio ends naturally
    audio.addEventListener('ended', function() {
      // Clear the currently playing audio reference
      currentlyPlayingAudio = null;
    });
  });
});
