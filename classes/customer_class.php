<?php
// Create a simple database connection class first
class Database {
    private $host = 'localhost';
    private $db_name = 'customer_portal';  
    private $username = 'root';            
    private $password = '';                
    protected $conn;

    public function __construct() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Customer class that extends database connection
class Customer extends Database {
    
    public function __construct() {
        parent::__construct();
    }

    // Add customer method (as required by assignment)
    public function add_customer($full_name, $email, $password, $country, $city, $contact, $user_role = 2) {
        try {
            // Check if email already exists
            if ($this->email_exists($email)) {
                return ['success' => false, 'message' => 'Email already exists'];
            }

            // Hash the password (encrypt as required by assignment)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO customers (full_name, email, password, country, city, contact_number, user_role, created_at) 
                    VALUES (:full_name, :email, :password, :country, :city, :contact, :user_role, NOW())";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':contact', $contact);
            $stmt->bindParam(':user_role', $user_role);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Customer registered successfully'];
            } else {
                return ['success' => false, 'message' => 'Registration failed'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Check if email exists (for email uniqueness as required)
    public function email_exists($email) {
        try {
            $sql = "SELECT id FROM customers WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Edit customer method
    public function edit_customer($id, $full_name, $email, $country, $city, $contact) {
        try {
            $sql = "UPDATE customers SET full_name = :full_name, email = :email, 
                    country = :country, city = :city, contact_number = :contact, 
                    updated_at = NOW() WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':contact', $contact);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Customer updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Update failed'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Delete customer method
    public function delete_customer($id) {
        try {
            $sql = "DELETE FROM customers WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Customer deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Delete failed'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Get customer by ID
    public function get_customer($id) {
        try {
            $sql = "SELECT * FROM customers WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Get all customers
    public function get_all_customers() {
        try {
            $sql = "SELECT * FROM customers ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>