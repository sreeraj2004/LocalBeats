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

  let currentMode = 'login'; // or 'signup'
  let currentType = 'User';  // or 'Musician'

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
});
