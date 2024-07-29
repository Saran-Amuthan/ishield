// Get the login popup button element
var loginPopupButton = document.getElementById("loginPopupButton");

// Get the signup popup button element
var signupPopupButton = document.getElementById("signupPopupButton");

// Get the login modal element
var loginModal = document.getElementById("loginModal");

// Get the signup modal element
var signupModal = document.getElementById("signupModal");

// Get the <span> elements that close the modals
var closeBtns = document.getElementsByClassName("close");

// Get the signup link element inside login modal
var signupLink = document.getElementById("signupLink");

// Get the login link element inside signup modal
var loginLink = document.getElementById("loginLink");

// Function to open the login modal
loginPopupButton.onclick = function() {
  loginModal.style.display = "block";
}

// Function to open the signup modal
signupPopupButton.onclick = function() {
  signupModal.style.display = "block";
}

// Loop through all close buttons and add event listeners to close the modals
for (var i = 0; i < closeBtns.length; i++) {
  closeBtns[i].onclick = function() {
    loginModal.style.display = "none";
    signupModal.style.display = "none";
  }
}

// When the user clicks on "Sign Up" link inside login modal
signupLink.onclick = function(event) {
  event.preventDefault(); // Prevent the link from navigating to another page
  loginModal.style.display = "none"; // Close the login modal
  signupModal.style.display = "block"; // Open the signup modal
}

// When the user clicks on "Login" link inside signup modal
loginLink.onclick = function(event) {
  event.preventDefault(); // Prevent the link from navigating to another page
  signupModal.style.display = "none"; // Close the signup modal
  loginModal.style.display = "block"; // Open the login modal
}

// When the user clicks anywhere outside of the modals, close them
window.onclick = function(event) {
  if (event.target == loginModal) {
    loginModal.style.display = "none";
  }
  if (event.target == signupModal) {
    signupModal.style.display = "none";
  }
}
