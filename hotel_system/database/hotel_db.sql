

-- 1. create the database (if it does not exist yet)
CREATE DATABASE IF NOT EXISTS hotel_db;

-- 2. select db use 
USE hotel_db;

-- 3. create the table for reservations 
CREATE TABLE IF NOT EXISTS reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    employee_id INT NOT NULL,
    employee_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
