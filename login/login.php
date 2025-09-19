<?php
session_start();

// If user is already logged in, redirect to index
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="login-wrapper">
            <div class="login-form">
                <h2>Welcome Back</h2>
                <p>Please sign in to your account.</p>
                
                <!-- General error message display -->
                <div class="error-message" id="generalError" style="display: none; margin-bottom: 1rem;"></div>
                
                <!-- Fully validated customer login form (as required by assignment) -->
                <form id="loginForm" novalidate>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required maxlength="100">
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                        <div class="error-message" id="passwordError"></div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    <!-- CSS/JS loading feature when login button is clicked (as suggested by assignment) -->
                    <div class="form-group">
                        <button type="submit" id="loginBtn" class="btn-primary">
                            Sign In
                            <span id="loadingSpinner" class="loading-spinner" style="display: none;">⟳</span>
                        </button>
                    </div>

                    <div class="form-footer">
                        <p>Don't have an account? <a href="register.php">Register here</a></p>
                        <p><a href="forgot-password.php">Forgot your password?</a></p>
                        <p><a href="../index.php">← Back to Home</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript file for form validation using regex (as required by assignment) -->
    <script src="../js/login.js"></script>
</body>
</html>