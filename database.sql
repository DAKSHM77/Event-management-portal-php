-- Database Schema for Event Management System

CREATE DATABASE IF NOT EXISTS event_management_db;
USE event_management_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'organization', 'student') NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive', 'blocked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Organizations Table
CREATE TABLE IF NOT EXISTS organizations (
    org_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    org_name VARCHAR(100) NOT NULL,
    description TEXT,
    document_path VARCHAR(255),
    approval_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE
);

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    org_id INT NOT NULL,
    category_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    venue VARCHAR(255),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    seat_limit INT NOT NULL,
    ticket_price DECIMAL(10, 2) DEFAULT 0.00,
    registration_deadline DATETIME NOT NULL,
    status ENUM('draft', 'pending', 'approved', 'rejected', 'completed', 'cancelled') DEFAULT 'draft',
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (org_id) REFERENCES organizations(org_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- Event Images Table
CREATE TABLE IF NOT EXISTS event_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Registrations Table
CREATE TABLE IF NOT EXISTS registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    registration_status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Payments Table
CREATE TABLE IF NOT EXISTS payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    transaction_id VARCHAR(100),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES registrations(registration_id) ON DELETE CASCADE
);

-- Tickets Table
CREATE TABLE IF NOT EXISTS tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    ticket_code VARCHAR(50) NOT NULL UNIQUE,
    qr_code_path VARCHAR(255),
    attendance_status ENUM('absent', 'present') DEFAULT 'absent',
    FOREIGN KEY (registration_id) REFERENCES registrations(registration_id) ON DELETE CASCADE
);

-- Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Payouts Table
CREATE TABLE IF NOT EXISTS payouts (
    payout_id INT AUTO_INCREMENT PRIMARY KEY,
    org_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payout_status ENUM('requested', 'processed', 'rejected') DEFAULT 'requested',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (org_id) REFERENCES organizations(org_id) ON DELETE CASCADE
);

-- Notifications Table
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Admin Logs Table
CREATE TABLE IF NOT EXISTS admin_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ==========================================
-- SEED DATA (Password for all: password123)
-- Hash: $2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa
-- ==========================================

-- 1. Categories
INSERT INTO categories (category_name) VALUES 
('Technology'), ('Music'), ('Sports'), ('Education'), ('Health'), ('Business'), ('Art'), ('Food'), ('Gaming'), ('Science');

-- 2. Users
-- Admin
INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES 
('Super Admin', 'admin@eventportal.com', '0000000000', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'admin', 1, 'active');

-- Organization Users
INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES 
('Tech Corp', 'org1@test.com', '1234567890', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'organization', 1, 'active'),
('Music Fest Inc', 'org2@test.com', '0987654321', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'organization', 1, 'active'),
('Sports World', 'org3@test.com', '1122334455', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'organization', 1, 'active');

-- Student Users
INSERT INTO users (name, email, phone, password, role, is_verified, status) VALUES 
('John Doe', 'john@test.com', '5555555555', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'student', 1, 'active'),
('Jane Smith', 'jane@test.com', '4444444444', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'student', 1, 'active');

-- 3. Organizations
INSERT INTO organizations (user_id, org_name, description, approval_status) VALUES 
((SELECT user_id FROM users WHERE email='org1@test.com'), 'Tech Corp', 'Leading tech event organizer.', 'approved'),
((SELECT user_id FROM users WHERE email='org2@test.com'), 'Music Fest Inc', 'Global music festivals.', 'approved'),
((SELECT user_id FROM users WHERE email='org3@test.com'), 'Sports World', 'Sports and marathons.', 'approved');

-- 4. Events
INSERT INTO events (org_id, category_id, title, description, venue, start_date, end_date, start_time, end_time, seat_limit, ticket_price, registration_deadline, status, created_at) VALUES 
((SELECT org_id FROM organizations WHERE org_name='Tech Corp'), (SELECT category_id FROM categories WHERE category_name='Technology'), 'Tech Summit 2025', 'The biggest tech conference.', 'Convention Center', CURDATE() + INTERVAL 10 DAY, CURDATE() + INTERVAL 12 DAY, '09:00:00', '18:00:00', 500, 150.00, CURDATE() + INTERVAL 5 DAY, 'approved', NOW()),
((SELECT org_id FROM organizations WHERE org_name='Music Fest Inc'), (SELECT category_id FROM categories WHERE category_name='Music'), 'Rock Concert Live', 'Live bands night.', 'City Stadium', CURDATE() + INTERVAL 20 DAY, CURDATE() + INTERVAL 20 DAY, '18:00:00', '23:00:00', 1000, 50.00, CURDATE() + INTERVAL 15 DAY, 'approved', NOW()),
((SELECT org_id FROM organizations WHERE org_name='Sports World'), (SELECT category_id FROM categories WHERE category_name='Sports'), 'City Marathon 2025', 'Run for charity.', 'Central Park', CURDATE() + INTERVAL 30 DAY, CURDATE() + INTERVAL 30 DAY, '06:00:00', '12:00:00', 2000, 20.00, CURDATE() + INTERVAL 25 DAY, 'approved', NOW()),
((SELECT org_id FROM organizations WHERE org_name='Tech Corp'), (SELECT category_id FROM categories WHERE category_name='Business'), 'Startup Bootcamp', 'Zero to One.', 'Innovation Hub', CURDATE() + INTERVAL 5 DAY, CURDATE() + INTERVAL 8 DAY, '10:00:00', '16:00:00', 50, 0.00, CURDATE() + INTERVAL 2 DAY, 'approved', NOW()),
((SELECT org_id FROM organizations WHERE org_name='Sports World'), (SELECT category_id FROM categories WHERE category_name='Gaming'), 'Gaming Championship', 'Esports Arena.', 'Arena 51', CURDATE() + INTERVAL 15 DAY, CURDATE() + INTERVAL 17 DAY, '10:00:00', '22:00:00', 300, 100.00, CURDATE() + INTERVAL 10 DAY, 'approved', NOW());

-- 5. Registrations (Dummy for John)
INSERT INTO registrations (event_id, user_id, registration_status, registered_at) VALUES 
((SELECT event_id FROM events WHERE title='Tech Summit 2025'), (SELECT user_id FROM users WHERE email='john@test.com'), 'confirmed', NOW()),
((SELECT event_id FROM events WHERE title='Rock Concert Live'), (SELECT user_id FROM users WHERE email='john@test.com'), 'confirmed', NOW());

-- 6. Tickets
INSERT INTO tickets (registration_id, ticket_code) VALUES 
((SELECT registration_id FROM registrations WHERE user_id=(SELECT user_id FROM users WHERE email='john@test.com') AND event_id=(SELECT event_id FROM events WHERE title='Tech Summit 2025')), 'TKT-TECH-JOHN'),
((SELECT registration_id FROM registrations WHERE user_id=(SELECT user_id FROM users WHERE email='john@test.com') AND event_id=(SELECT event_id FROM events WHERE title='Rock Concert Live')), 'TKT-ROCK-JOHN');
