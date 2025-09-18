<?php
require_once '../classes/customer_class.php';

class CustomerController {
    private $customer;

    public function __construct() {
        $this->customer = new Customer();
    }

    // Register customer controller (as required by assignment: register_customer_ctr($kwargs))
    public function register_customer_ctr($kwargs) {
        // Validate required fields
        $required_fields = ['full_name', 'email', 'password', 'country', 'city', 'contact'];
        foreach ($required_fields as $field) {
            if (!isset($kwargs[$field]) || empty(trim($kwargs[$field]))) {
                return ['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'];
            }
        }

        // Validate email format
        if (!filter_var($kwargs['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        // Validate password strength (at least 8 characters, 1 uppercase, 1 lowercase, 1 number)
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/', $kwargs['password'])) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters with uppercase, lowercase, and number'];
        }

        // Validate phone number (basic validation)
        if (!preg_match('/^[\+]?[0-9\s\-\(\)]{10,15}$/', $kwargs['contact'])) {
            return ['success' => false, 'message' => 'Invalid phone number format'];
        }

        // Validate field lengths based on database schema
        if (strlen($kwargs['full_name']) > 50) {
            return ['success' => false, 'message' => 'Full name must be 50 characters or less'];
        }
        if (strlen($kwargs['email']) > 100) {
            return ['success' => false, 'message' => 'Email must be 100 characters or less'];
        }
        if (strlen($kwargs['country']) > 30) {
            return ['success' => false, 'message' => 'Country must be 30 characters or less'];
        }
        if (strlen($kwargs['city']) > 30) {
            return ['success' => false, 'message' => 'City must be 30 characters or less'];
        }
        if (strlen($kwargs['contact']) > 15) {
            return ['success' => false, 'message' => 'Contact number must be 15 characters or less'];
        }

        // Set default user role if not provided (2 for customer as per assignment)
        $user_role = isset($kwargs['user_role']) ? $kwargs['user_role'] : 2;

        // Call the customer model to add the customer (invokes customer_class::add method)
        return $this->customer->add_customer(
            trim($kwargs['full_name']),
            trim($kwargs['email']),
            $kwargs['password'],
            trim($kwargs['country']),
            trim($kwargs['city']),
            trim($kwargs['contact']),
            $user_role
        );
    }

    // Check email availability controller
    public function check_email_availability_ctr($email) {
        if (empty($email)) {
            return ['success' => false, 'message' => 'Email is required'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $exists = $this->customer->email_exists($email);
        return ['success' => true, 'available' => !$exists];
    }

    // Edit customer controller
    public function edit_customer_ctr($kwargs) {
        if (!isset($kwargs['id']) || empty($kwargs['id'])) {
            return ['success' => false, 'message' => 'Customer ID is required'];
        }

        return $this->customer->edit_customer(
            $kwargs['id'],
            $kwargs['full_name'],
            $kwargs['email'],
            $kwargs['country'],
            $kwargs['city'],
            $kwargs['contact']
        );
    }

    // Delete customer controller
    public function delete_customer_ctr($id) {
        if (empty($id)) {
            return ['success' => false, 'message' => 'Customer ID is required'];
        }

        return $this->customer->delete_customer($id);
    }

    // Get customer controller
    public function get_customer_ctr($id) {
        if (empty($id)) {
            return ['success' => false, 'message' => 'Customer ID is required'];
        }

        $customer = $this->customer->get_customer($id);
        if ($customer) {
            return ['success' => true, 'customer' => $customer];
        } else {
            return ['success' => false, 'message' => 'Customer not found'];
        }
    }

    // Get all customers controller
    public function get_all_customers_ctr() {
        $customers = $this->customer->get_all_customers();
        return ['success' => true, 'customers' => $customers];
    }
}
?>