<?php
session_start();
require_once '../config/database.php'; // your DB connection

// Redirect if not instructor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit;
}

$instructor_id = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);

// Database connection
$db = (new Database())->getConnection();

// Fetch dynamic stats
// 1. Total courses taught
$stmt = $db->prepare("SELECT COUNT(*) as total_courses FROM courses WHERE instructor_id = ?");
$stmt->execute([$instructor_id]);
$total_courses = $stmt->fetch(PDO::FETCH_ASSOC)['total_courses'] ?? 0;

// 2. Total students across all courses
$stmt = $db->prepare("SELECT COUNT(DISTINCT student_id) as total_students 
                      FROM enrollments 
                      WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)");
$stmt->execute([$instructor_id]);
$total_students = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'] ?? 0;

// 3. Total assignments given
$stmt = $db->prepare("SELECT COUNT(*) as total_assignments 
                      FROM assignments 
                      WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)");
$stmt->execute([$instructor_id]);
$total_assignments = $stmt->fetch(PDO::FETCH_ASSOC)['total_assignments'] ?? 0;

// 4. Total exams conducted
$stmt = $db->prepare("SELECT COUNT(*) as total_exams 
                      FROM exams 
                      WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)");
$stmt->execute([$instructor_id]);
$total_exams = $stmt->fetch(PDO::FETCH_ASSOC)['total_exams'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - SkillPro Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard-style.css"> <!-- use separate CSS file -->
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4><i class="bi bi-mortarboard"></i> SkillPro</h4>
    <a href="profile.php"><i class="bi bi-person-badge"></i> Profile</a>
    <a href="my_courses.php"><i class="bi bi-journal-bookmark"></i> My Courses</a>
    <a href="upload_materials.php"><i class="bi bi-upload"></i> Upload Materials</a>
    <a href="manage_assignments.php"><i class="bi bi-clipboard-data"></i> Manage Assignments</a>
    <a href="grade_exams.php"><i class="bi bi-check2-square"></i> Grade Exams</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="welcome">
        <h2>Welcome, Instructor <?php echo $username; ?> 👨‍🏫</h2>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_courses; ?></div>
            <div class="stat-label">Courses Taught</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_students; ?></div>
            <div class="stat-label">Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_assignments; ?></div>
            <div class="stat-label">Assignments Given</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_exams; ?></div>
            <div class="stat-label">Exams Conducted</div>
        </div>
    </div>

    <p>Manage your courses, upload study materials, create assignments, and evaluate exams from this dashboard.</p>
</div>

</body>
</html>
