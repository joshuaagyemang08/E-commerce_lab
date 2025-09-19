// Form validation patterns using regex (as required by assignment)
const validationPatterns = {
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
};

// Error messages
const errorMessages = {
    required: 'This field is required',
    email: 'Please enter a valid email address',
    password: 'Password is required'
};

// Show loading state (CSS/JS loading feature as suggested by assignment)
function showLoading() {
    const submitBtn = document.getElementById('loginBtn');
    const loader = document.getElementById('loadingSpinner');
    
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Signing In...';
    }
    
    if (loader) {
        loader.style.display = 'inline-block';
    }
}

// Hide loading state
function hideLoading() {
    const submitBtn = document.getElementById('loginBtn');
    const loader = document.getElementById('loadingSpinner');
    
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Sign In';
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
    const fields = ['email', 'password'];
    fields.forEach(field => clearError(field));
    
    // Clear general error message
    const generalError = document.getElementById('generalError');
    if (generalError) {
        generalError.style.display = 'none';
    }
}

// Show general error message
function showGeneralError(message) {
    const generalError = document.getElementById('generalError');
    if (generalError) {
        generalError.textContent = message;
        generalError.style.display = 'block';
    } else {
        // If no general error div, show alert
        alert('Login failed: ' + message);
    }
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
        case 'email':
            if (!validationPatterns.email.test(value)) {
                showError(fieldId, errorMessages.email);
                return false;
            }
            break;
            
        case 'password':
            // For login, just check if password is not empty
            if (value.length === 0) {
                showError(fieldId, errorMessages.password);
                return false;
            }
            break;
    }
    
    return true;
}

// Validate entire form
function validateForm() {
    const fields = [
        { id: 'email', value: document.getElementById('email').value },
        { id: 'password', value: document.getElementById('password').value }
    ];
    
    let isValid = true;
    
    // Validate each field using regex (check for types as required)
    for (const field of fields) {
        if (!validateField(field.id, field.value)) {
            isValid = false;
        }
    }
    
    return isValid;
}

// Submit login form asynchronously (as required by assignment)
async function submitLogin() {
    clearAllErrors();
    
    // Validate form using regex
    const isValid = validateForm();
    if (!isValid) {
        return;
    }
    
    showLoading();
    
    // Collect form data
    const formData = {
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value
    };
    
    try {
        // Asynchronously invoke the login_customer_action script (as required by assignment)
        const response = await fetch('../actions/login_customer_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show success message
            alert('Login successful! Redirecting to dashboard...');
            
            // On successful login, direct user to landing page (index.php) as required by assignment
            window.location.href = result.redirect || '../index.php';
        } else {
            // Show error message
            showGeneralError(result.message);
        }
        
    } catch (error) {
        console.error('Login error:', error);
        showGeneralError('Login failed. Please try again.');
    } finally {
        hideLoading();
    }
}

// Initialize form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('loginBtn');
    
    // Add real-time validation
    const fields = ['email', 'password'];
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
    
    // Handle form submission (asynchronous as required)
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLogin();
        });
    }
    
    // Handle button click
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            submitLogin();
        });
    }
});