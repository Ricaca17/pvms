-- Database schema for Prison Visitor Management System

-- Create database
CREATE DATABASE IF NOT EXISTS prison_visitor_system;
USE prison_visitor_system;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, role, created_at)
VALUES ('admin', '$2y$10$8zf0bvFUxHC0PoP.jI3ZB.fsFBmkm16QW7Eo7vWmHnWwTzLg4gkS2', 'admin@example.com', 'admin', NOW());

-- Prisoners table
CREATE TABLE IF NOT EXISTS prisoners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    id_number VARCHAR(50) NOT NULL UNIQUE,
    crime VARCHAR(100) NOT NULL,
    sentence VARCHAR(50) NOT NULL,
    admission_date DATE NOT NULL,
    release_date DATE NOT NULL,
    cell VARCHAR(50) NOT NULL,
    security_level ENUM('Low', 'Medium', 'High', 'Maximum') NOT NULL,
    health_status ENUM('Good', 'Fair', 'Poor', 'Critical') NOT NULL,
    emergency_contact_name VARCHAR(100) NOT NULL,
    emergency_contact_relation VARCHAR(50) NOT NULL,
    emergency_contact_phone VARCHAR(20) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL
);

-- Insert sample prisoners
INSERT INTO prisoners (first_name, last_name, age, gender, id_number, crime, sentence, admission_date, release_date, cell, security_level, health_status, emergency_contact_name, emergency_contact_relation, emergency_contact_phone, created_at)
VALUES 
('Juan', 'Dela Cruz', 35, 'male', 'P001', 'Fraud', '5 years', '2020-03-15', '2025-03-15', 'Block A-101', 'Medium', 'Good', 'Maria Dela Cruz', 'Wife', '555-123-4567', NOW()),
('Wilson', 'Dizon', 42, 'male', 'P002', 'Robbery', '8 years', '2018-07-22', '2026-07-22', 'Block B-205', 'High', 'Good', 'Elena Dizon', 'Sister', '555-234-5678', NOW()),
('Roberto', 'Mendoza', 29, 'male', 'P003', 'Drug possession', '3 years', '2021-01-10', '2024-01-10', 'Block A-115', 'Low', 'Good', 'Carlos Mendoza', 'Brother', '555-345-6789', NOW()),
('Carlos', 'Reyes', 38, 'male', 'P004', 'Assault', '4 years', '2020-09-05', '2024-09-05', 'Block C-302', 'Medium', 'Fair', 'Ana Reyes', 'Wife', '555-456-7890', NOW()),
('Eduardo', 'Santos', 45, 'male', 'P005', 'Murder', '25 years', '2015-11-30', '2040-11-30', 'Block D-401', 'Maximum', 'Good', 'Lucia Santos', 'Mother', '555-567-8901', NOW()),
('Fernando', 'Lopez', 33, 'male', 'P006', 'Theft', '2 years', '2022-02-15', '2024-02-15', 'Block B-210', 'Low', 'Good', 'Isabella Lopez', 'Wife', '555-678-9012', NOW()),
('Gabriel', 'Torres', 27, 'male', 'P007', 'Fraud', '3 years', '2021-05-20', '2024-05-20', 'Block A-105', 'Medium', 'Good', 'Sofia Torres', 'Sister', '555-789-0123', NOW());

-- Visitors table
CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    id_type ENUM('national', 'drivers', 'passport', 'other') NOT NULL,
    id_number VARCHAR(50) NOT NULL,
    relationship ENUM('family', 'spouse', 'legal', 'friend', 'other') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL
);

-- Insert sample visitors
INSERT INTO visitors (first_name, last_name, id_type, id_number, relationship, phone, email, address, created_at)
VALUES 
('Miguel', 'Bautista', 'national', 'V001', 'family', '555-111-2222', 'miguel@example.com', '123 Main St, Manila', NOW()),
('Juana', 'Reyes', 'passport', 'V002', 'legal', '555-222-3333', 'juana@example.com', '456 Oak Ave, Quezon City', NOW()),
('Pedro', 'Santos', 'drivers', 'V003', 'family', '555-333-4444', 'pedro@example.com', '789 Pine St, Makati', NOW()),
('Maria', 'Santos', 'national', 'V004', 'family', '555-444-5555', 'maria@example.com', '789 Pine St, Makati', NOW());

-- Visits table
CREATE TABLE IF NOT EXISTS visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitor_id INT NOT NULL,
    prisoner_id INT NOT NULL,
    visit_purpose ENUM('family', 'legal', 'social', 'other') NOT NULL,
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    duration VARCHAR(20) DEFAULT NULL,
    status ENUM('Scheduled', 'In Progress', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Scheduled',
    activation_code VARCHAR(10) NOT NULL,
    entry_time DATETIME DEFAULT NULL,
    exit_time DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE,
    FOREIGN KEY (prisoner_id) REFERENCES prisoners(id) ON DELETE CASCADE
);

-- Insert sample visits (using current date - 644, 645, 646 days for historical data)
INSERT INTO visits (visitor_id, prisoner_id, visit_purpose, visit_date, visit_time, status, activation_code, entry_time, exit_time, created_at)
VALUES 
(1, 2, 'family', DATE_SUB(CURDATE(), INTERVAL 644 DAY), '11:30:00', 'Completed', '123456', 
 DATE_SUB(NOW(), INTERVAL 644 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 644 DAY), INTERVAL 75 MINUTE), DATE_SUB(NOW(), INTERVAL 645 DAY)),
(2, 3, 'legal', DATE_SUB(CURDATE(), INTERVAL 645 DAY), '14:00:00', 'Completed', '234567', 
 DATE_SUB(NOW(), INTERVAL 645 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 645 DAY), INTERVAL 60 MINUTE), DATE_SUB(NOW(), INTERVAL 646 DAY)),
(3, 1, 'family', DATE_SUB(CURDATE(), INTERVAL 646 DAY), '10:00:00', 'Completed', '345678', 
 DATE_SUB(NOW(), INTERVAL 646 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 646 DAY), INTERVAL 90 MINUTE), DATE_SUB(NOW(), INTERVAL 647 DAY)),
(4, 1, 'family', DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:00:00', 'Scheduled', '456789', NULL, NULL, NOW());

-- Behavior records table
CREATE TABLE IF NOT EXISTS behavior_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prisoner_id INT NOT NULL,
    description TEXT NOT NULL,
    record_date DATE NOT NULL,
    type ENUM('positive', 'negative') NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (prisoner_id) REFERENCES prisoners(id) ON DELETE CASCADE
);

-- Insert sample behavior records
INSERT INTO behavior_records (prisoner_id, description, record_date, type, created_at)
VALUES 
(1, 'Good behavior - Participated in community service', '2023-06-01', 'positive', NOW()),
(1, 'Verbal altercation with another inmate', '2023-04-15', 'negative', NOW());
