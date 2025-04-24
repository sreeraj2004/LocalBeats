document.addEventListener('DOMContentLoaded', function () {
  console.log('DOM Content Loaded');

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
  const navLogoutBtn = document.getElementById('navLogoutBtn');
  const dashboardLogoutBtn = document.getElementById('dashboardLogoutBtn');
  const addEventBtn = document.getElementById('addEventBtn');
  const addMusicBtn = document.getElementById('addMusicBtn');

  const eventForm = document.getElementById('eventForm');
  const musicForm = document.getElementById('musicForm');

  const eventFormPopup = document.getElementById('eventFormPopup');
  const musicFormPopup = document.getElementById('musicFormPopup');

  const musicToggleBtn = document.getElementById('musicToggleBtn');
  const eventToggleBtn = document.getElementById('eventToggleBtn');
  const musicSection = document.getElementById('musicSection');
  const eventSection = document.getElementById('eventSection');

  let currentMode = 'login';
  let currentType = 'User';

  // Navigation links
  const homeLink = document.querySelector('.home-link').parentElement;
  const musiciansLink = document.querySelector('.musicians-link').parentElement;
  const eventsLink = document.querySelector('.events-link').parentElement;
  const musicLink = document.querySelector('.music-link').parentElement;
  const aboutLink = document.querySelector('.about-link').parentElement;

  // Add click event listeners to protected links
  if (musiciansLink) {
    musiciansLink.addEventListener('click', function(e) {
      if (!sessionStorage.getItem('userType')) {
        e.preventDefault();
        alert('Please log in to access this page');
        showPopup('login');
      }
    });
  }

  if (eventsLink) {
    eventsLink.addEventListener('click', function(e) {
      if (!sessionStorage.getItem('userType')) {
        e.preventDefault();
        alert('Please log in to access this page');
        showPopup('login');
      }
    });
  }

  if (musicLink) {
    musicLink.addEventListener('click', function(e) {
      if (!sessionStorage.getItem('userType')) {
        e.preventDefault();
        alert('Please log in to access this page');
        showPopup('login');
      }
    });
  }

  // Add protection for the about page
  if (aboutLink) {
    aboutLink.addEventListener('click', function(e) {
      if (!sessionStorage.getItem('userType')) {
        e.preventDefault();
        alert('Please log in to access this page');
        showPopup('login');
      }
    });
  }

  // Check authentication state on page load
  function checkAuthState() {
    const storedType = sessionStorage.getItem('userType');
    if (storedType) {
      // User is logged in
      loginBtn.style.display = 'none';
      signupBtn.style.display = 'none';
      
      if (storedType === 'Musician') {
        dashboardBtn.style.display = 'inline-block';
        navLogoutBtn.style.display = 'none';
        if (addEventBtn) addEventBtn.style.display = 'block';
        if (addMusicBtn) addMusicBtn.style.display = 'block';
      } else {
        dashboardBtn.style.display = 'none';
        navLogoutBtn.style.display = 'inline-block';
        if (addEventBtn) addEventBtn.style.display = 'none';
        if (addMusicBtn) addMusicBtn.style.display = 'none';
      }
      
      // Update navigation based on user type
      updateNavigation(storedType);
      
      // Only redirect if on the welcome page
      const currentPath = window.location.pathname;
      if (currentPath === '/' || currentPath === '') {
        if (storedType === 'Musician') {
          window.location.href = '/about';
        } else {
          window.location.href = '/home';
        }
      }
    } else {
      // User is not logged in
      loginBtn.style.display = 'inline-block';
      signupBtn.style.display = 'inline-block';
      dashboardBtn.style.display = 'none';
      navLogoutBtn.style.display = 'none';
      if (addEventBtn) addEventBtn.style.display = 'none';
      if (addMusicBtn) addMusicBtn.style.display = 'none';
      
      // Show all navigation links for non-logged in users except about
      homeLink.style.display = 'block';
      musiciansLink.style.display = 'block';
      eventsLink.style.display = 'block';
      musicLink.style.display = 'block';
      aboutLink.style.display = 'none';
      
      // Check if we're on the about page and redirect if not logged in
      const currentPath = window.location.pathname;
      if (currentPath === '/about') {
        window.location.href = '/home';
      }
    }
  }

  // Call checkAuthState on page load
  checkAuthState();

  // Function to get element with retry
  function getElementWithRetry(id, maxRetries = 3) {
    let element = document.getElementById(id);
    let retries = 0;
    
    while (!element && retries < maxRetries) {
      console.log(`Retrying to find element: ${id}, attempt ${retries + 1}`);
      element = document.getElementById(id);
      retries++;
    }
    
    if (!element) {
      console.error(`Element not found after ${maxRetries} retries: ${id}`);
      // Log all elements with IDs for debugging
      console.log('All elements with IDs:', Array.from(document.querySelectorAll('[id]')).map(el => el.id));
    }
    
    return element;
  }

  // Function to show popup
  function showPopup(popupId) {
    console.log(`Attempting to show popup: ${popupId}`);
    const popup = document.getElementById(popupId);
    console.log('Popup element:', popup);
    
    if (popup) {
      console.log(`Showing popup: ${popupId}`);
      // Remove any existing display style
      popup.removeAttribute('style');
      // Add the active class
      popup.classList.add('active');
      // Ensure the popup is visible
      popup.style.display = 'flex';
      popup.style.position = 'fixed';
      popup.style.top = '0';
      popup.style.left = '0';
      popup.style.width = '100%';
      popup.style.height = '100%';
      popup.style.justifyContent = 'center';
      popup.style.alignItems = 'center';
      popup.style.zIndex = '1000';
    } else {
      console.error(`Popup element not found: ${popupId}`);
      // Try to find the element again
      const retryElement = getElementWithRetry(popupId);
      if (retryElement) {
        console.log('Found element on retry, showing popup');
        retryElement.removeAttribute('style');
        retryElement.classList.add('active');
        retryElement.style.display = 'flex';
        retryElement.style.position = 'fixed';
        retryElement.style.top = '0';
        retryElement.style.left = '0';
        retryElement.style.width = '100%';
        retryElement.style.height = '100%';
        retryElement.style.justifyContent = 'center';
        retryElement.style.alignItems = 'center';
        retryElement.style.zIndex = '1000';
      }
    }
  }

  // Function to hide popup
  function hidePopup(popupId) {
    const popup = document.getElementById(popupId);
    if (popup) {
      popup.style.display = 'none';
      popup.classList.remove('active');
    }
  }

  function updateForm() {
    formTitle.innerText = `${currentType} ${currentMode === 'login' ? 'Login' : 'Sign Up'}`;
    submitBtn.innerText = currentMode === 'login' ? 'Login' : 'Sign Up';
    switchMode.innerText = currentMode === 'login' ? 'Sign Up' : 'Login';

    nameField.style.display = currentMode === 'signup' ? 'block' : 'none';
    confirmPasswordField.style.display = currentMode === 'signup' ? 'block' : 'none';

    musicianFields.style.display = (currentMode === 'signup' && currentType === 'Musician') ? 'block' : 'none';
  }

  loginBtn.onclick = () => {
    currentMode = 'login';
    updateForm();
    showPopup('popupOverlay');
  };
  
  signupBtn.onclick = () => {
    currentMode = 'signup';
    updateForm();
    showPopup('popupOverlay');
  };
  
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

  // Form submission handler
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(form);
    let action;
    
    if (currentMode === 'login') {
      action = currentType === 'User' ? '/login/user' : '/login/musician';
    } else {
      action = currentType === 'User' ? '/register/user' : '/register/musician';
    }
    
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: {
        'Accept': 'application/json'
      }
    })
    .then(response => {
      if (!response.ok) {
        return response.json().then(data => {
          throw new Error(data.message || 'Login failed');
        });
      }
      return response.json();
    })
    .then(data => {
      if (data.message === 'Login successful') {
        sessionStorage.setItem('userType', currentType);
        sessionStorage.setItem('userName', data.user.name);
        if (data.isMusician) {
          sessionStorage.setItem('musicianId', data.musician.id);
        }
        // Clear form fields
        form.reset();
        hidePopup('popupOverlay');
        window.location.href = data.redirect || '/';
      } else {
        alert(data.message || 'An error occurred');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert(error.message || 'An error occurred. Please try again.');
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

  // Function to handle logout
  function handleLogout() {
    fetch('/logout', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      credentials: 'same-origin'
    })
    .then(response => {
      if (response.ok) {
        sessionStorage.clear();
        window.location.href = '/';
      }
    })
    .catch(error => {
      console.error('Logout error:', error);
    });
  }

  // Add click handlers for both logout buttons
  if (navLogoutBtn) navLogoutBtn.onclick = handleLogout;
  if (dashboardLogoutBtn) dashboardLogoutBtn.onclick = handleLogout;

  // Initialize Show More/Less functionality if elements exist
  if (musicToggleBtn && eventToggleBtn && musicSection && eventSection) {
    musicToggleBtn.addEventListener('click', () => {
      musicSection.style.display = musicSection.style.display === 'none' ? 'block' : 'none';
      musicToggleBtn.textContent = musicSection.style.display === 'none' ? 'Show Music' : 'Hide Music';
    });

    eventToggleBtn.addEventListener('click', () => {
      eventSection.style.display = eventSection.style.display === 'none' ? 'block' : 'none';
      eventToggleBtn.textContent = eventSection.style.display === 'none' ? 'Show Events' : 'Hide Events';
    });
  }

  // Add event listeners for add buttons
  if (addEventBtn) {
    addEventBtn.addEventListener('click', function() {
      console.log('Add Event button clicked');
      showPopup('eventFormPopup');
      hidePopup('musicFormPopup');
    });
  }

  if (addMusicBtn) {
    addMusicBtn.addEventListener('click', function() {
      console.log('Add Music button clicked');
      showPopup('musicFormPopup');
      hidePopup('eventFormPopup');
    });
  }

  // Add close button functionality
  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const popup = this.closest('.form-popup');
      if (popup) {
        hidePopup(popup.id);
      }
    });
  });

  // Add click outside to close functionality
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('form-popup')) {
      hidePopup(event.target.id);
    }
  });

  // Add event listeners for music and event forms
  console.log('Checking music form elements:');
  console.log('Music form:', musicForm);
  console.log('Music form popup:', musicFormPopup);
  
  if (musicForm) {
    console.log('Music form found, checking for file input...');
    const musicFileInput = document.getElementById('musicFile');
    console.log('Music file input:', musicFileInput);
    
    if (!musicFileInput) {
      console.error('Music file input not found in form');
      // Try to find it again after a short delay
      setTimeout(() => {
        const retryMusicFileInput = document.getElementById('musicFile');
        console.log('Retry - Music file input:', retryMusicFileInput);
        if (!retryMusicFileInput) {
          console.error('Music file input still not found after retry');
          // Log all form elements to help debug
          console.log('All form elements:', Array.from(musicForm.elements).map(el => ({
            id: el.id,
            name: el.name,
            type: el.type
          })));
        }
      }, 1000);
    }
    
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
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        credentials: 'include'
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
          if (musicFormPopup) {
            musicFormPopup.style.display = 'none';
          }
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
  } else {
    console.error('Music form not found');
  }

  if (eventForm) {
    eventForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Check if user is authenticated
      if (!sessionStorage.getItem('userType')) {
        alert('Please log in to add an event');
        showPopup('popupOverlay');
        currentMode = 'login';
        updateForm();
        return;
      }
      
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

  // Community section signup button
  const communitySignupBtn = document.getElementById('communitySignupBtn');
  if (communitySignupBtn) {
    communitySignupBtn.addEventListener('click', function() {
      popupOverlay.style.display = 'flex';
      currentMode = 'signup';
      updateFormFields();
    });
  }

  // Function to update navigation based on user type
  function updateNavigation(userType) {
    if (userType === 'Musician') {
      // Hide user-specific links
      homeLink.style.display = 'none';
      musiciansLink.style.display = 'none';
      // Show musician-specific links
      musicLink.style.display = 'block';
      eventsLink.style.display = 'block';
      aboutLink.style.display = 'block';
    } else if (userType === 'User') {
      // Show user-specific links
      homeLink.style.display = 'block';
      musiciansLink.style.display = 'block';
      eventsLink.style.display = 'block';
      musicLink.style.display = 'block';
      // Hide musician-specific links
      aboutLink.style.display = 'none';
    } else {
      // For non-logged in users, show all links except about
      homeLink.style.display = 'block';
      musiciansLink.style.display = 'block';
      eventsLink.style.display = 'block';
      musicLink.style.display = 'block';
      aboutLink.style.display = 'none';
    }
  }

  // Update navigation on page load if user is logged in
  const storedType = sessionStorage.getItem('userType');
  if (storedType) {
    updateNavigation(storedType);
  }
});

// Show More/Show Less functionality - moved outside the nested DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing Show More/Less functionality');
  
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

function handleProfilePhotoUpload(event) {
    event.preventDefault();
    const fileInput = document.getElementById('profile-photo-input');
    const file = fileInput.files[0];

    if (!file) {
        alert('Please select a file to upload');
        return;
    }

    const formData = new FormData();
    formData.append('profile_photo', file);

    fetch('/update-profile-photo', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile photo updated successfully');
            // Refresh the page to show the new photo
            window.location.reload();
        } else {
            alert(data.message || 'Error updating profile photo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating profile photo');
    });
}
