<?php
// -------------------------
// Start session safely
// -------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -------------------------
// Sanitize input
// -------------------------
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

// -------------------------
// Login / role checks
// -------------------------
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

// -------------------------
// Alerts
// -------------------------
function showAlert($message, $type = 'info') {
    return "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
}

// -------------------------
// Database connection
// -------------------------
function getDBConnection() {
    require_once __DIR__ . '/../config/database.php';
    $database = new Database();
    return $database->getConnection();
}

// -------------------------
// User / student functions
// -------------------------
function getUserById($id) {
    $db = getDBConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// -------------------------
// Courses
// -------------------------
function getCourseById($course_id) {
    $db = getDBConnection();
    $stmt = $db->prepare("
        SELECT c.*, 
               cat.name AS category_name, 
               b.name AS branch_name,
               i.name AS instructor_name,
               i.email AS instructor_email,
               i.phone AS instructor_phone,
               i.expertise AS instructor_expertise
        FROM courses c
        LEFT JOIN categories cat ON c.category_id = cat.id
        LEFT JOIN branches b ON c.branch_id = b.id
        LEFT JOIN instructors i ON c.instructor_id = i.id
        WHERE c.id = :id
    ");
    $stmt->execute([':id' => $course_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCourses($limit = 50, $offset = 0, $search = '') {
    $db = getDBConnection();
    $stmt = $db->prepare("
        SELECT c.*, 
               cat.name AS category_name, 
               b.name AS branch_name,
               i.name AS instructor_name,
               i.expertise AS instructor_expertise
        FROM courses c
        LEFT JOIN categories cat ON c.category_id = cat.id
        LEFT JOIN branches b ON c.branch_id = b.id
        LEFT JOIN instructors i ON c.instructor_id = i.id
        WHERE c.title LIKE :search OR c.description LIKE :search
        ORDER BY c.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// -------------------------
// Student enrolled courses
// -------------------------
function getStudentCourses($student_id) {
    $db = getDBConnection();
    $stmt = $db->prepare("
        SELECT c.*
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.student_id = :student_id
        ORDER BY e.created_at DESC
    ");
    $stmt->execute([':student_id' => $student_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// -------------------------
// Notifications / events
// -------------------------
function getNotifications($limit = 5) {
    $db = getDBConnection();
    $stmt = $db->prepare("SELECT * FROM notifications ORDER BY created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
