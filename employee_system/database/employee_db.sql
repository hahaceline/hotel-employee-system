



CREATE DATABASE IF NOT EXISTS employee_db;


USE employee_db;


CREATE TABLE IF NOT EXISTS employee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO employee (employee_name, position, department) VALUES
('Juan Dela Cruz', 'Receptionist', 'Front Office'),
('Maria Santos', 'Manager', 'Administration'),
('Pedro Reyes', 'Housekeeper', 'Housekeeping'),
('Ana Lim', 'Accountant', 'Finance'),
('Carlos Garcia', 'Bellboy', 'Front Office'),
('Grace Tan', 'Chef', 'Food & Beverage'),
('Michael Cruz', 'Security Guard', 'Security'),
('Liza Ramos', 'HR Officer', 'Human Resources'),
('Ramon Torres', 'Maintenance Staff', 'Maintenance'),
('Sophia Aquino', 'Front Desk Supervisor', 'Front Office');
