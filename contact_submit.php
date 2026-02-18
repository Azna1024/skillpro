<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Initialize response message
$message = "";

// Check if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate and sanitize input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $content = trim($_POST['message'] ?? '');

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($content)) {
        $errors[] = "Message cannot be empty.";
    }

    // If no validation errors, insert into DB
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO inquiries (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $content]);
            
            $_SESSION['success'] = "Your message has been sent successfully!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
    }

    // Redirect back to contact page
    header("Location: contact.php");
    exit;
} else {
    // Invalid access
    header("Location: contact.php");
    exit;
}
?>
