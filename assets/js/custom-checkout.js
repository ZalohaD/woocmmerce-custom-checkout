document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('custom-checkout-form');
    const emailInput = document.getElementById('billing_email');

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showError(input, message) {
        input.classList.add('error');
        let errorMsg = input.parentNode.querySelector('.error-message');
        if (!errorMsg) {
            errorMsg = document.createElement('span');
            errorMsg.className = 'error-message';
            input.parentNode.appendChild(errorMsg);
        }
        errorMsg.textContent = message;
    }

    function removeError(input) {
        input.classList.remove('error');
        const errorMsg = input.parentNode.querySelector('.error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    }

    emailInput.addEventListener('input', function() {
        if (this.value.trim() === '') {
            removeError(this);
        } else if (!validateEmail(this.value)) {
            showError(this, 'Please enter a valid email address');
        } else {
            removeError(this);
        }
    });

    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showError(field, 'This field is required');
                isValid = false;
            } else {
                removeError(field);
            }
        });

        if (emailInput.value.trim() && !validateEmail(emailInput.value)) {
            showError(emailInput, 'Please enter a valid email address');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            const firstError = form.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
            }
        }
    });

    const allInputs = form.querySelectorAll('input[required]');
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this !== emailInput && this.value.trim()) {
                removeError(this);
            }
        });
    });
});