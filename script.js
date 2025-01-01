let submitButton = document.querySelector('.submit-btn');
let inputName = document.querySelector('input[name="name"]');
let inputEmail = document.querySelector('input[name="email"]');
let errorMessage = document.querySelector('.error-message');
let form = document.querySelector('#js-input-form');
let successMessage = document.querySelector('.success-message');

submitButton.disabled = true;
successMessage.innerHTML = 'Please complete the fields above.';

function validateForm() {
    function validate() {
        let name = inputName.value;
        let email = inputEmail.value;
        let valid = true;
        
        if (name === '' || email === '') {
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
        }

        if (valid) {
            successMessage.innerHTML = 'You may now submit the form';
            submitButton.disabled = false;
        }
    }

    inputName.addEventListener('keyup', validate);
    inputEmail.addEventListener('keyup', validate);
}

document.addEventListener('DOMContentLoaded', validateForm);