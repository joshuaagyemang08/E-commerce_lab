<?php
session_start(); // Start session for login

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../controllers/customer_controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        // If JSON input is empty, try $_POST
        if (empty($input)) {
            $input = $_POST;
        }

        // Validate input
        if (empty($input)) {
            echo json_encode([
                'success' => false,
                'message' => 'No data received'
            ]);
            exit;
        }

        // Create controller instance
        $customer_controller = new CustomerController();
        
        // Login customer (invokes relevant function from customer controller as required)
        $result = $customer_controller->login_customer_ctr($input);
        
        if ($result['success']) {
            // Set session variables for user ID, role, name, and other attributes (as required by assignment)
            $customer = $result['customer'];
            
            $_SESSION['customer_id'] = $customer['id'];
            $_SESSION['customer_name'] = $customer['full_name'];
            $_SESSION['customer_email'] = $customer['email'];
            $_SESSION['customer_role'] = $customer['user_role'];
            $_SESSION['customer_country'] = $customer['country'];
            $_SESSION['customer_city'] = $customer['city'];
            $_SESSION['customer_contact'] = $customer['contact_number'];
            $_SESSION['login_time'] = time();
            $_SESSION['is_logged_in'] = true;

            // Return success response
            $result['message'] = 'Login successful';
            $result['redirect'] = '../index.php'; // Redirect to landing page as required
        }
        
        // Return result as JSON (returns message to caller as required)
        echo json_encode($result);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method allowed'
    ]);
}
?>