document.addEventListener('DOMContentLoaded', function () {
    var loginBtn = document.getElementById('loginBtn');
    var signupBtn = document.getElementById('signupBtn');
    var popupOverlay = document.getElementById('popupOverlay');
    var closePopup = document.getElementById('closePopup');
    var formTitle = document.getElementById('formTitle');
    var submitBtn = document.querySelector('.submit-btn');
    var switchMode = document.getElementById('switchMode');
    var signupFields = document.getElementById('signupFields');
    var userTab = document.getElementById('userTab');
    var musicianTab = document.getElementById('musicianTab');
  
    var currentMode = 'login';
    var currentType = 'User';
  
    function showPopup(mode) {
      currentMode = mode;
      popupOverlay.style.display = 'flex';
      updateForm();
    }
  
    function updateForm() {
      formTitle.innerText = currentType + ' ' + (currentMode === 'login' ? 'Login' : 'Sign Up');
      submitBtn.innerText = currentMode === 'login' ? 'Login' : 'Sign Up';
      switchMode.innerText = currentMode === 'login' ? 'Sign Up' : 'Login';
      signupFields.style.display = currentMode === 'signup' ? 'block' : 'none';
    }
  
    if (loginBtn && signupBtn && closePopup && switchMode && userTab && musicianTab) {
      loginBtn.onclick = function () {
        showPopup('login');
      };
  
      signupBtn.onclick = function () {
        showPopup('signup');
      };
  
      closePopup.onclick = function () {
        popupOverlay.style.display = 'none';
      };
  
      switchMode.onclick = function (e) {
        e.preventDefault();
        currentMode = currentMode === 'login' ? 'signup' : 'login';
        updateForm();
      };
  
      userTab.onclick = function () {
        currentType = 'User';
        userTab.classList.add('active');
        musicianTab.classList.remove('active');
        updateForm();
      };
  
      musicianTab.onclick = function () {
        currentType = 'Musician';
        musicianTab.classList.add('active');
        userTab.classList.remove('active');
        updateForm();
      };
    }
  });
  