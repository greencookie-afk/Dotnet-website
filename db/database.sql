-- Create database
CREATE DATABASE IF NOT EXISTS dotnet_website;
USE dotnet_website;

-- Create admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- Create services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) NOT NULL,
    details TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Create contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create site settings table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_name VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO admin_users (username, password, email) 
VALUES ('admin', '$2y$10$8KQT9.QCiuWgQbQD7kJHUOLfEr3Dj6Zs.ksVJyXLQNO0zp0n2D0Hy', 'admin@dotnet.com');

-- Insert default site settings
INSERT INTO site_settings (setting_name, setting_value) VALUES
('site_name', 'Dotnet'),
('site_description', 'Bringing your digital products to life quickly with no-code and low-code solutions'),
('contact_email', 'info@dotnet.com'),
('contact_phone', '(123) 456-7890'),
('contact_address', '123 Tech Street, Digital City');

-- Insert default services
INSERT INTO services (title, description, icon, details) VALUES
('Custom Applications', 'Tailor-made solutions designed specifically for your business needs.', 'bi-code-square', 'Our custom application development service provides tailored solutions that address your specific business challenges. We work closely with you to understand your requirements and deliver applications that streamline your operations and enhance productivity.'),
('Automation Workflows', 'Streamline your business processes with intelligent automation.', 'bi-gear', 'Automate repetitive tasks and streamline your business processes with our cutting-edge automation solutions. Our team will identify opportunities for automation in your workflow and implement efficient solutions that save time and reduce errors.'),
('Database Solutions', 'Efficient data management systems tailored to your requirements.', 'bi-database', 'Our database solutions provide robust and scalable data management systems that ensure data integrity, security, and accessibility. We design and implement database architectures that optimize performance and support your business growth.');
