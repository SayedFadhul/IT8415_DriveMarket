document.addEventListener("DOMContentLoaded", function () {
function showError(input, message) {
clearError(input);
        const error = document.createElement("div");
        error.className = "js-error-message";
        error.textContent = message;
        input.classList.add("input-error");
        input.parentNode.appendChild(error);
        }

function clearError(input) {
input.classList.remove("input-error");
        const oldError = input.parentNode.querySelector(".js-error-message");
        if (oldError) {
oldError.remove();
        }
}

function isValidEmail(email) {
return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

const loginForm = document.getElementById("loginForm");
        if (loginForm) {
loginForm.addEventListener("submit", function (e) {
let valid = true;
        const loginInput = document.getElementById("login_input");
        const password = document.getElementById("password");
        clearError(loginInput);
        clearError(password);
        if (!loginInput.value.trim()) {
showError(loginInput, "Username or email is required.");
        valid = false;
        }

if (!password.value.trim()) {
showError(password, "Password is required.");
        valid = false;
        }

if (!valid) {
e.preventDefault();
        }
});
        }

const registerForm = document.getElementById("registerForm");
        if (registerForm) {
registerForm.addEventListener("submit", function (e) {
let valid = true;
        const username = document.getElementById("username");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");
        [username, email, password, confirmPassword].forEach(clearError);
        if (!username.value.trim()) {
showError(username, "Username is required.");
        valid = false;
        }

if (!email.value.trim()) {
showError(email, "Email is required.");
        valid = false;
        } else if (!isValidEmail(email.value.trim())) {
showError(email, "Enter a valid email address.");
        valid = false;
        }

if (!password.value.trim()) {
showError(password, "Password is required.");
        valid = false;
        } else if (password.value.length < 6) {
showError(password, "Password must be at least 6 characters.");
        valid = false;
        }

if (!confirmPassword.value.trim()) {
showError(confirmPassword, "Please confirm your password.");
        valid = false;
        } else if (password.value !== confirmPassword.value) {
showError(confirmPassword, "Passwords do not match.");
        valid = false;
        }

if (!valid) {
e.preventDefault();
        }
});
        }

const editProfileForm = document.getElementById("editProfileForm");
        if (editProfileForm) {
editProfileForm.addEventListener("submit", function (e) {
let valid = true;
        const username = document.getElementById("username");
        const email = document.getElementById("email");
        const currentPassword = document.getElementById("current_password");
        const newPassword = document.getElementById("new_password");
        const confirmNewPassword = document.getElementById("confirm_new_password");
        [username, email, currentPassword, newPassword, confirmNewPassword].forEach(clearError);
        if (!username.value.trim()) {
showError(username, "Username is required.");
        valid = false;
        }

if (!email.value.trim()) {
showError(email, "Email is required.");
        valid = false;
        } else if (!isValidEmail(email.value.trim())) {
showError(email, "Enter a valid email address.");
        valid = false;
        }

if (!currentPassword.value.trim()) {
showError(currentPassword, "Current password is required.");
        valid = false;
        }

if (newPassword.value.trim() || confirmNewPassword.value.trim()) {
if (newPassword.value.length < 6) {
showError(newPassword, "New password must be at least 6 characters.");
        valid = false;
        }

if (newPassword.value !== confirmNewPassword.value) {
showError(confirmNewPassword, "New passwords do not match.");
        valid = false;
        }
}

if (!valid) {
e.preventDefault();
        }
});
        }

const carForms = document.querySelectorAll(".carValidationForm");
        carForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
        let valid = true;
                const title = form.querySelector("#title");
                const shortDescription = form.querySelector("#short_description");
                const fullDescription = form.querySelector("#full_description");
                const brand = form.querySelector("#brand");
                const model = form.querySelector("#model");
                const year = form.querySelector("#car_year");
                const price = form.querySelector("#price");
        [title, shortDescription, fullDescription, brand, model, year, price].forEach(clearError);
                if (!title.value.trim()) {
        showError(title, "Title is required.");
                valid = false;
        }

        if (!shortDescription.value.trim()) {
        showError(shortDescription, "Short description is required.");
                valid = false;
        }

        if (!fullDescription.value.trim()) {
        showError(fullDescription, "Full description is required.");
                valid = false;
        }

        if (!brand.value.trim()) {
        showError(brand, "Brand is required.");
                valid = false;
        }

        if (!model.value.trim()) {
        showError(model, "Model is required.");
                valid = false;
        }

        const currentYear = new Date().getFullYear();
                if (!year.value || parseInt(year.value, 10) < 1900 || parseInt(year.value, 10) > currentYear + 1) {
        showError(year, "Enter a valid car year.");
                valid = false;
        }

        if (!price.value || parseFloat(price.value) <= 0) {
        showError(price, "Price must be greater than 0.");
                valid = false;
        }

        if (!valid) {
        e.preventDefault();
        }
        });
        });
        const appointmentForm = document.getElementById("appointmentForm");
        if (appointmentForm) {
appointmentForm.addEventListener("submit", function (e) {
let valid = true;
        const car = document.getElementById("car_id");
        const date = document.getElementById("appointment_date");
        const time = document.getElementById("appointment_time");
        [car, date, time].forEach(clearError);
        if (!car.value) {
showError(car, "Please select a car.");
        valid = false;
        }

if (!date.value) {
showError(date, "Please select a date.");
        valid = false;
        }

if (!time.value) {
showError(time, "Please select a time.");
        valid = false;
        }

if (date.value && time.value) {
const now = new Date();
        const selectedDateTime = new Date(date.value + "T" + time.value);
        if (selectedDateTime < now) {
showError(time, "Appointment date/time cannot be in the past.");
        valid = false;
        }
}

if (!valid) {
e.preventDefault();
        }
});
});