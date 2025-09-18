<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="registration-wrapper">
            <div class="registration-form">
                <h2>Create Your Account</h2>
                <p>Please fill in all the required fields to register.</p>
                
                <!-- Form has NO action attribute since asynchronous logic in register.js handles onSubmission events -->
                <form id="registrationForm" novalidate>
                    <!-- Full name field (required by assignment) -->
                    <div class="form-group">
                        <label for="fullName">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" required maxlength="50">
                        <div class="error-message" id="fullNameError"></div>
                    </div>

                    <!-- Email field - unique field, check availability before adding (required by assignment) -->
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required maxlength="100">
                        <small class="form-hint">Must be a unique email address</small>
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <!-- Password field - encrypt before adding to database (required by assignment) -->
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required minlength="8">
                        <small class="form-hint">At least 8 characters with uppercase, lowercase, and number</small>
                        <div class="error-message" id="passwordError"></div>
                    </div>

                    <!-- Confirm password for validation -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password *</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required>
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>

                    <!-- Country field (required by assignment) -->
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="country">Country *</label>
                            <input type="text" id="country" name="country" required maxlength="30">
                            <div class="error-message" id="countryError"></div>
                        </div>

                        <!-- City field (required by assignment) -->
                        <div class="form-group half">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required maxlength="30">
                            <div class="error-message" id="cityError"></div>
                        </div>
                    </div>

                    <!-- Contact Number field (required by assignment) -->
                    <div class="form-group">
                        <label for="contact">Contact Number *</label>
                        <input type="tel" id="contact" name="contact" required maxlength="15">
                        <small class="form-hint">10-15 digits with optional country code</small>
                        <div class="error-message" id="contactError"></div>
                    </div>

                    <!-- Image field is null by default, not needed on sign-up (as per assignment) -->
                    <!-- User role field set to default value from SQL level (as per assignment) -->

                    <!-- Register button with CSS/JS loading feature (as suggested by assignment) -->
                    <div class="form-group">
                        <button type="submit" id="registerBtn" class="btn-primary">
                            Register
                            <span id="loadingSpinner" class="loading-spinner" style="display: none;">⟳</span>
                        </button>
                    </div>

                    <div class="form-footer">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                        <p><a href="../index.php">← Back to Home</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript file for form validation using regex (as required by assignment) -->
    <script src="../js/register.js"></script>
</body>
</html>