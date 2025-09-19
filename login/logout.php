<?php
// Redirect to logout action which handles the session destruction
header('Location: ../actions/logout_action.php');
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Customer Portal</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta http-equiv="refresh" content="3;url=../index.php">
</head>
<body>
    <div class="container">
        <div class="login-wrapper">
            <div class="login-form">
                <h2>Logged Out Successfully</h2>
                <p>You have been successfully logged out of your account.</p>
                
                <div class="logout-message">
                    <div class="feature-icon">✓</div>
                    <h3>Thank you for using our service!</h3>
                    <p>You will be redirected to the home page in 3 seconds...</p>
                </div>

                <div class="form-footer">
                    <p><a href="../index.php">Go to Home Page</a></p>
                    <p><a href="login.php">Login Again</a></p>
                    <p><a href="register.php">Create New Account</a></p>
                </div>
            </div>
        </div>
    </div>

    <style>
    .logout-message {
        text-align: center;
        padding: 2rem 0;
    }
    
    .logout-message .feature-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .logout-message h3 {
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .logout-message p {
        color: #666;
        font-size: 0.9rem;
    }
    </style>
</body>
</html>