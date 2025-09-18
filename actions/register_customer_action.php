<?php
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
        
        // Register customer
        $result = $customer_controller->register_customer_ctr($input);
        
        // Return result as JSON
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