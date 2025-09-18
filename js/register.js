// Form validation patterns using regex (as required by assignment)
const validationPatterns = {
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/,
    phone: /^[\+]?[0-9\s\-\(\)]{10,15}$/,
    name: /^[a-zA-Z\s]{2,50}$/,
    city: /^[a-zA-Z\s]{2,30}$/,
    country: /^[a-zA-Z\s]{2,30}$/
};

// Error messages
const errorMessages = {
    required: 'This field is required',
    email: 'Please enter a valid email address',
    password: 'Password must be at least 8 characters with uppercase, lowercase, and number',
    phone: 'Please enter a valid phone number (10-15 digits)',
    name: 'Name must contain only letters and be 2-50 characters long',
    city: 'City must contain only letters and be 2-30 characters long',
    country: 'Country must contain only letters and be 2-30 characters long',
    emailExists: 'Email already exists. Please use a different email.'
};

// Show loading state
function showLoading() {
    const submitBtn = document.getElementById('registerBtn');
    const loader = document.getElementById('loadingSpinner');
    
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Registering...';
    }
    
    if (loader) {
        loader.style.display = 'inline-block';
    }
}

// Hide loading state
function hideLoading() {
    const submitBtn = document.getElementById('registerBtn');
    const loader = document.getElementById('loadingSpinner');
    
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Register';
    }
    
    if (loader) {
        loader.style.display = 'none';
    }
}

// Show error message
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + 'Error');
    
    if (field) {
        field.classList.add('error');
    }
    
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
}

// Clear error message
function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + 'Error');
    
    if (field) {
        field.classList.remove('error');
    }
    
    if (errorDiv) {
        errorDiv.textContent = '';
        errorDiv.style.display = 'none';
    }
}

// Clear all errors
function clearAllErrors() {
    const fields = ['fullName', 'email', 'password', 'confirmPassword', 'country', 'city', 'contact'];
    fields.forEach(field => clearError(field));
}

// Validate individual field using regex (as required by assignment)
function validateField(fieldId, value) {
    clearError(fieldId);
    
    // Check if field is required and empty
    if (!value || value.trim() === '') {
        showError(fieldId, errorMessages.required);
        return false;
    }
    
    // Specific validation based on field using regex
    switch (fieldId) {
        case 'fullName':
            if (!validationPatterns.name.test(value)) {
                showError(fieldId, errorMessages.name);
                return false;
            }
            break;
            
        case 'email':
            if (!validationPatterns.email.test(value)) {
                showError(fieldId, errorMessages.email);
                return false;
            }
            break;
            
        case 'password':
            if (!validationPatterns.password.test(value)) {
                showError(fieldId, errorMessages.password);
                return false;
            }
            break;
            
        case 'confirmPassword':
            const password = document.getElementById('password').value;
            if (value !== password) {
                showError(fieldId, 'Passwords do not match');
                return false;
            }
            break;
            
        case 'country':
            if (!validationPatterns.country.test(value)) {
                showError(fieldId, errorMessages.country);
                return false;
            }
            break;
            
        case 'city':
            if (!validationPatterns.city.test(value)) {
                showError(fieldId, errorMessages.city);
                return false;
            }
            break;
            
        case 'contact':
            if (!validationPatterns.phone.test(value)) {
                showError(fieldId, errorMessages.phone);
                return false;
            }
            break;
    }
    
    return true;
}

// Check email availability before adding new customer (as required by assignment)
async function checkEmailAvailability(email) {
    try {
        // Updated path for login folder structure
        const response = await fetch('../actions/check_email_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email })
        });
        
        const result = await response.json();
        
        if (result.success && !result.available) {
            showError('email', errorMessages.emailExists);
            return false;
        }
        
        return true;
    } catch (error) {
        console.error('Error checking email availability:', error);
        return true; // Continue with registration if check fails
    }
}

// Validate entire form
async function validateForm() {
    const fields = [
        { id: 'fullName', value: document.getElementById('fullName').value },
        { id: 'email', value: document.getElementById('email').value },
        { id: 'password', value: document.getElementById('password').value },
        { id: 'confirmPassword', value: document.getElementById('confirmPassword').value },
        { id: 'country', value: document.getElementById('country').value },
        { id: 'city', value: document.getElementById('city').value },
        { id: 'contact', value: document.getElementById('contact').value }
    ];
    
    let isValid = true;
    
    // Validate each field using regex
    for (const field of fields) {
        if (!validateField(field.id, field.value)) {
            isValid = false;
        }
    }
    
    // Check email availability if email is valid (as required by assignment)
    if (isValid && validationPatterns.email.test(fields[1].value)) {
        const emailAvailable = await checkEmailAvailability(fields[1].value);
        if (!emailAvailable) {
            isValid = false;
        }
    }
    
    return isValid;
}

// Submit registration form asynchronously (as required by assignment)
async function submitRegistration() {
    clearAllErrors();
    
    // Validate form using regex
    const isValid = await validateForm();
    if (!isValid) {
        return;
    }
    
    showLoading();
    
    // Collect form data
    const formData = {
        full_name: document.getElementById('fullName').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        country: document.getElementById('country').value.trim(),
        city: document.getElementById('city').value.trim(),
        contact: document.getElementById('contact').value.trim()
    };
    
    try {
        // Updated path for login folder structure - Asynchronously invoke the register_customer_action script
        const response = await fetch('../actions/register_customer_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            alert('Registration successful! You will be redirected to the login page.');
            
            // On successful registration, direct user to login page (as required by assignment)
            window.location.href = 'login.php';
        } else {
            // Show error message
            alert('Registration failed: ' + result.message);
        }
        
    } catch (error) {
        console.error('Registration error:', error);
        alert('Registration failed. Please try again.');
    } finally {
        hideLoading();
    }
}

// Initialize form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('registerBtn');
    
    // Add real-time validation
    const fields = ['fullName', 'email', 'password', 'confirmPassword', 'country', 'city', 'contact'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', function() {
                validateField(fieldId, this.value);
            });
            
            field.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    clearError(fieldId);
                }
            });
        }
    });
    
    // Handle form submission (no form action since JS handles onSubmission events as required)
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitRegistration();
        });
    }
    
    // Handle button click
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            submitRegistration();
        });
    }
});