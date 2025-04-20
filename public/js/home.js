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

    if (currentMode === 'signup' && currentType === 'Musician') {
      musicianFields.style.display = 'block';
    } else {
      musicianFields.style.display = 'none';
    }
  }

  loginBtn.onclick = () => showPopup('login');
  signupBtn.onclick = () => showPopup('signup');
  closePopup.onclick = () => popupOverlay.style.display = 'none';

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
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
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

        // Show dashboard buttons based on user type
        if (currentType === 'Musician') {
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
});
