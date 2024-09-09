// Get the form element and submit button
const form = document.querySelector("form");
const submitBtn = document.querySelector('button[type="submit"]');

submitBtn.addEventListener("click", (e) => {
  e.preventDefault();
  // Get the input value
  const inputEmail = document.querySelector('input[name="email"]').value;
  const inputPassword = document.querySelector('input[name="password"]').value;
  let errorMessages = document.querySelector(".errorMessage");
  // Check if the input is empty
  if (inputEmail === "") {
    errorMessages.innerHTML = "Please enter your email";
    inputEmail.focus();
    return;
  } else if (!isValidEmail(inputEmail)) {
    errorMessages.innerHTML = "Your email is not correct";
    inputEmail.focus();
    return;
  }

  if (inputPassword === "") {
    errorMessages.innerHTML = "Please enter your password";
    inputPassword.focus();
    return;
  } else if (inputPassword.length < 6) {
    errorMessages.innerHTML =
      "Your password must contain at least 6 characters";
    inputPassword.focus();
    return;
  }

  form.submit();
});

// Function to validate email format
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
