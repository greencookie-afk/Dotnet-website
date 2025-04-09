<?php
// Include configuration
require_once 'config.php';

/**
 * Get page title based on current page
 */
function getPageTitle() {
    $current_page = basename($_SERVER['PHP_SELF']);
    
    switch ($current_page) {
        case 'index.php':
            return 'Home';
        case 'services.php':
            return 'Services';
        case 'contact.php':
            return 'Contact Us';
        default:
            return 'Dotnet';
    }
}

/**
 * Check if current page matches given page
 */
function isCurrentPage($page) {
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page === $page;
}

/**
 * Get all services from database
 */
function getServices() {
    global $conn;
    
    $services = [];
    $query = "SELECT * FROM services ORDER BY id ASC";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $services[] = $row;
        }
    }
    
    return $services;
}

/**
 * Get service by ID
 */
function getServiceById($id) {
    global $conn;
    
    $id = (int) $id;
    $query = "SELECT * FROM services WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

/**
 * Process contact form submission
 */
function processContactForm() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $message = sanitize($_POST['message']);
        
        $query = "INSERT INTO contact_messages (name, email, message, created_at) 
                  VALUES ('$name', '$email', '$message', NOW())";
        
        if (mysqli_query($conn, $query)) {
            return [
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to send message. Please try again.'
            ];
        }
    }
    
    return null;
}
?>
