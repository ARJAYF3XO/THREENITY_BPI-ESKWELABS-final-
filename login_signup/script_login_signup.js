const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");

// Get references to signup form inputs
const signupForm = document.querySelector("form.signup");
const signupEmailInput = document.getElementById("signupEmail");
const signupPasswordInput = document.getElementById("signupPassword");
const signupConfirmPasswordInput = document.getElementById("signupConfirmPassword");

// --- Event Listeners for Tab Switching ---
signupBtn.onclick = () => {
  loginForm.style.marginLeft = "-50%";
  loginText.style.marginLeft = "-50%";
};

loginBtn.onclick = () => {
  loginForm.style.marginLeft = "0%";
  loginText.style.marginLeft = "0%";
};

signupLink.onclick = () => {
  signupBtn.click();
  return false; // Prevent default link behavior
};

// --- Client-side validation for signup ---
signupForm.addEventListener("submit", function (event) {
  const email = signupEmailInput.value.trim();
  const password = signupPasswordInput.value.trim();
  const confirmPassword = signupConfirmPasswordInput.value.trim();

  // Basic email regex (more forgiving but catches common mistakes)
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!emailRegex.test(email)) {
    alert("❌ Please enter a valid email address.");
    event.preventDefault();
    return;
  }

  if (password.length < 6) {
    alert("❌ Password must be at least 6 characters long.");
    event.preventDefault();
    return;
  }

  if (password !== confirmPassword) {
    alert("❌ Passwords do not match.");
    event.preventDefault();
    return;
  }
});
