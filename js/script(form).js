function togglePassword(eyeicon) {
    var password = eyeicon.previousElementSibling;
    if (password.type === "password") {
        password.type = "text";
        eyeicon.src = "images/invisible.png";
    } else {
        password.type = "password";
        eyeicon.src = "images/visible.png";
    }
}


const usernameInput = document.querySelector('.username');
const namePattern = document.querySelector('.name-pattern');
const psswdInput = document.querySelector('.password');
const psswdLen = document.querySelector('.pssw-len');
const psswdChar = document.querySelector('.pssw-char');
const psswdMatch = document.querySelector('.password-cf');

//check username
if (usernameInput !== null && namePattern !== null) {
    usernameInput.addEventListener('input', function() {
        if (/^[a-zA-z][a-zA-Z0-9_]+$/.test(usernameInput.value)) {
            namePattern.classList.add("valid");
            namePattern.classList.remove("invalid");
        } else {
            namePattern.classList.add("invalid");
            namePattern.classList.remove("valid");
        }
    });
}

var correctPsswdchar = false;
var correctPsswdlen = false;
if (psswdInput !== null && psswdLen !== null && psswdChar !== null) {
    psswdInput.addEventListener('input', function() {
        // check password
        if (psswdInput.value.length >= 8) {
            psswdLen.classList.add("valid");
            psswdLen.classList.remove("invalid");
            correctPsswdlen = true;
        } else {
            psswdLen.classList.add("invalid");
            psswdLen.classList.remove("valid");
            correctPsswdlen = false;
        }

        if (/[a-zA-Z]/.test(psswdInput.value) && /[0-9]/.test(psswdInput.value)) {
            if (/[^a-zA-Z0-9.!?@#$%^&*]/.test(psswdInput.value)) {
                correctPsswdchar = false;
            }
            else {
                correctPsswdchar = true;
            }
        } else {
            correctPsswdchar = false;
        }
        
        if (correctPsswdchar) {
            psswdChar.classList.add("valid");
            psswdChar.classList.remove("invalid");
        } else {
            psswdChar.classList.add("invalid");
            psswdChar.classList.remove("valid");
        }
    });
}

if(psswdMatch!== null) {
    psswdMatch.addEventListener('input', function() {
        if (psswdInput.value.length > 0 && 
            psswdInput.value === psswdMatch.value && 
            psswdChar.classList.contains("valid") && 
            psswdLen.classList.contains("valid")) 
        {
            psswdMatch.classList.add("valid-border");
            psswdMatch.classList.remove("invalid-border");
        } else {
            psswdMatch.classList.add("invalid-border");
            psswdMatch.classList.remove("valid-border");
        }
    });
}

// Prevent form submission if any of the fields are invalid
var signupForm = document.querySelector(".signup-form");
if (signupForm !== null) {
    signupForm.addEventListener("submit", function(event) {
        if (namePattern.classList.contains("invalid") || 
            psswdChar.classList.contains("invalid") || 
            psswdLen.classList.contains("invalid") || 
            psswdMatch.classList.contains("invalid-border"))
        {
            
            event.preventDefault(); // Stop form submission
            alert("Please complete all required fields correctly before submitting.");
        }
    });
}

var resetForm = document.querySelector(".reset-form");
if (resetForm !== null) {
    resetForm.addEventListener("submit", function(event) {
        if (psswdChar.classList.contains("invalid") || 
            psswdLen.classList.contains("invalid") || 
            psswdMatch.classList.contains("invalid-border"))
        {
            event.preventDefault(); // Stop form submission
            alert("Please complete all required fields correctly before submitting.");
        }
    });
}

// Always check the input fields
if (usernameInput !== null) {
    document.addEventListener("DOMContentLoaded", function() {
        usernameInput.dispatchEvent(new Event('input'));
        psswdInput.dispatchEvent(new Event('input'));
        if (psswdMatch) psswdMatch.dispatchEvent(new Event('input'));
    });
}

