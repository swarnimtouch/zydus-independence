document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('detailsForm');
    if (!form) return;

    const nameInput = document.getElementById('name');
    const cityInput = document.getElementById('city');
    const specialityInput = document.getElementById('speciality');

    const nameError = document.getElementById('nameError');
    const cityError = document.getElementById('cityError');
    const specialityError = document.getElementById('specialityError');

    function showError(input, errorEl, message) {
        input.classList.add('input-error');
        errorEl.textContent = message;
    }

    function clearError(input, errorEl) {
        input.classList.remove('input-error');
        errorEl.textContent = '';
    }

    function validateField(input, errorEl, fieldLabel) {
        const value = input.value.trim();

        if (value === '') {
            showError(input, errorEl, fieldLabel + ' is required.');
            return false;
        }

        if (value.length < 2) {
            showError(input, errorEl, fieldLabel + ' must be at least 2 characters long.');
            return false;
        }

        clearError(input, errorEl);
        return true;
    }

    // Validate live as the user types
    nameInput.addEventListener('input', () => validateField(nameInput, nameError, 'Name'));
    cityInput.addEventListener('input', () => validateField(cityInput, cityError, 'City'));
    specialityInput.addEventListener('input', () => validateField(specialityInput, specialityError, 'Speciality'));

    // Validate before the form actually submits
    form.addEventListener('submit', function (e) {
        const isNameValid = validateField(nameInput, nameError, 'Name');
        const isCityValid = validateField(cityInput, cityError, 'City');
        const isSpecialityValid = validateField(specialityInput, specialityError, 'Speciality');

        if (!isNameValid || !isCityValid || !isSpecialityValid) {
            e.preventDefault();
        }
    });
});
