-- Create database for customer registration system
CREATE DATABASE IF NOT EXISTS customer_portal;
USE customer_portal;

-- Create customers table with all required fields from assignment
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(50) NOT NULL,                    -- Full name field (required)
    email VARCHAR(100) NOT NULL UNIQUE,               -- Email field - unique as required
    password VARCHAR(255) NOT NULL,                   -- Password field - encrypted before storage
    country VARCHAR(30) NOT NULL,                     -- Country field (required)
    city VARCHAR(30) NOT NULL,                        -- City field (required)
    contact_number VARCHAR(15) NOT NULL,              -- Contact Number field (required)
    image VARCHAR(255) NULL DEFAULT NULL,             -- Image field - null by default, not required on signup
    user_role TINYINT NOT NULL DEFAULT 2 COMMENT '1=Administrator, 2=Customer',  -- User role: 1=Admin, 2=Customer (required from SQL level)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Indexes for better performance
    INDEX idx_email (email),
    INDEX idx_user_role (user_role)
);

-- Insert a sample administrator user for testing (password is 'Admin123!')
INSERT INTO customers (
    full_name, 
    email, 
    password, 
    country, 
    city, 
    contact_number, 
    user_role
) VALUES (
    'System Administrator',
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3