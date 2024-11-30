const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    // Check if the signup form submission was successful
    if (!signupError.textContent.trim()) {
        // If there's no error message, add the "active" class to the container
        container.classList.add("active");
    }
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

//=======================


