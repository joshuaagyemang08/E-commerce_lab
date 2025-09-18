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
                
                <!-- Simple PHP login form with no functionality (as required by assignment) -->
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-primary">Sign In</button>
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

    <!-- Note: No functionality implemented as per assignment requirements -->
</body>
</html>