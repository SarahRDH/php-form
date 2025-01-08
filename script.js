let submitButton = document.querySelector('.submit-btn');
let inputName = document.querySelector('input[name="name"]');
let inputEmail = document.querySelector('input[name="email"]');
let inputPassword = document.querySelector('input[name="password"]');
let inputTabs = document.querySelector('#tabs');
let inputSpaces = document.querySelector('#spaces');
let errorMessage = document.querySelector('.error-message');
let form = document.querySelector('#js-input-form');
let successMessage = document.querySelector('.success-message');

submitButton.disabled = true;

function validateForm() {
    function validate() {
        let name = inputName.value;
        let email = inputEmail.value;
        let password = inputPassword.value;
        let tabsSelected = inputTabs.checked;
        let spacesSelected = inputSpaces.checked;
        let valid = true;

        if (name === '' || email === '' || password === '') {
            errorMessage.innerHTML = 'Please fill out all fields';
            valid = false;
        } else {
            errorMessage.innerHTML = '';
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                errorMessage.innerHTML = 'Please enter a valid email';
                valid = false;
            }
            if (name.length > 30) {
                errorMessage.innerHTML = 'Name is too long';
                valid = false;
            }
            if (password.length < 8) {
                errorMessage.innerHTML = 'Password must be at least 8 characters';
                valid = false;
            }
            if (!tabsSelected && !spacesSelected) {
                errorMessage.innerHTML = 'Please select a preference';
                valid = false;
            } else if (spacesSelected) {
                errorMessage.innerHTML = 'Well that\'s disappointing...';
            }
        }

        if (valid) {
            successMessage.innerHTML = 'You may now submit the form!';
            submitButton.disabled = false;
        }
    }

    inputName.addEventListener('keyup', validate);
    inputEmail.addEventListener('keyup', validate);
    inputPassword.addEventListener('keyup', validate);
    inputTabs.addEventListener('click', validate);
    inputSpaces.addEventListener('click', validate);
}

document.addEventListener('DOMContentLoaded', validateForm);