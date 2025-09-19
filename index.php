<?php
session_start();
// Check if customer is logged in (for future functionality)
$isLoggedIn = isset($_SESSION['customer_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Customer Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Minimal menu tray showing Register/Login buttons when customer is not logged in (as required by assignment) -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1>Customer Portal</h1>
            </div>
            
            <div class="nav-menu">
                <?php if (!$isLoggedIn): ?>
                    <!-- Show Register/Login buttons when customer is not logged in -->
                    <a href="login/login.php" class="nav-link btn-outline">Login</a>
                    <a href="login/register.php" class="nav-link btn-primary">Register</a>
                <?php else: ?>
                    <!-- Show user info when logged in - Logout button as required by assignment -->
                    <span class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?>!</span>
                    <span class="nav-link">Role: <?php echo $_SESSION['customer_role'] == 1 ? 'Administrator' : 'Customer'; ?></span>
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                    <a href="profile.php" class="nav-link">Profile</a>
                    <a href="actions/logout_action.php" class="nav-link btn-outline">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="hero-section">
            <div class="container">
                <h1>Welcome to Our Customer Portal</h1>
                <p>Your gateway to managing your account and accessing our services.</p>
                
                <?php if (!$isLoggedIn): ?>
                    <!-- Show registration call-to-action when not logged in -->
                    <div class="cta-buttons">
                        <a href="login/register.php" class="btn-primary btn-large">Get Started - Register Now</a>
                        <a href="login/login.php" class="btn-outline btn-large">Already have an account? Sign In</a>
                    </div>
                <?php else: ?>
                    <!-- Show dashboard options when logged in -->
                    <div class="cta-buttons">
                        <a href="dashboard.php" class="btn-primary btn-large">Go to Dashboard</a>
                        <a href="profile.php" class="btn-outline btn-large">View Profile</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="features-section">
            <div class="container">
                <h2>Why Register With Us?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h3>Secure Registration</h3>
                        <p>Your data is protected with encrypted passwords and secure validation.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3>Quick & Easy</h3>
                        <p>Simple registration process with real-time validation and feedback.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <h3>Personalized Experience</h3>
                        <p>Access your personal dashboard and manage your account settings.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Customer Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>