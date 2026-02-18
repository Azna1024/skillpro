<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Include Database class
require_once 'config/database.php';

// Get user info
$user_id = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);
$role = $_SESSION['role'];
$age = isset($_SESSION['age']) ? (int)$_SESSION['age'] : '';

// Initialize stats
$stats = [];

// Fetch role-specific stats
if ($role === 'admin') {
    
    $stats = [
        'total_courses' => 10,
        'instructors' => 5,
        'students' => 50,
        'pending_approvals' => 3
    ];
} elseif ($role === 'instructor') {
    $db = (new Database())->getConnection();

    // Courses taught by this instructor
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM courses WHERE instructor_id = ?");
    $stmt->execute([$user_id]);
    $stats['courses_taught'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Total students in instructor's courses
    $stmt = $db->prepare("
        SELECT COUNT(DISTINCT student_id) as total 
        FROM enrollments 
        WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)
    ");
    $stmt->execute([$user_id]);
    $stats['total_students'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Assignments given in instructor's courses
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM assignments 
        WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)
    ");
    $stmt->execute([$user_id]);
    $stats['assignments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Exams conducted in instructor's courses
    $stmt = $db->prepare("
        SELECT COUNT(*) as total 
        FROM exams 
        WHERE course_id IN (SELECT id FROM courses WHERE instructor_id = ?)
    ");
    $stmt->execute([$user_id]);
    $stats['exams'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
}

 elseif ($role === 'student') {
    // Student stats (dummy data, replace with DB queries if needed)
    $stats = [
        'enrolled_courses' => 5,
        'completed' => 3,
        'average_score' => 85,
        'assignments' => 4,
        'exams' => 2
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo ucfirst($role); ?> Dashboard - SkillPro Institute</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --primary-color: <?php echo $role === 'admin' ? '#667eea' : ($role === 'instructor' ? '#28a745' : '#1976d2'); ?>;
    --secondary-color: <?php echo $role === 'admin' ? '#764ba2' : ($role === 'instructor' ? '#218838' : '#1565c0'); ?>;
    --background-color: #f5f7fa;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

body { font-family: "Segoe UI", Arial, sans-serif; background: var(--background-color); margin:0; }

/* Sidebar */
.sidebar { height: 100vh; width: 250px; position: fixed; top:0; left:0; background-color: var(--primary-color); color:white; display:flex; flex-direction:column; z-index:1000; }
.sidebar .logo { font-size:1.5rem; font-weight:bold; text-align:center; padding:1.5rem 0; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar ul { list-style:none; padding:0; margin:0; flex:1; }
.sidebar ul li a { display:flex; align-items:center; padding:1rem 1.2rem; color:white; text-decoration:none; font-weight:500; transition: all 0.3s; }
.sidebar ul li a:hover, .sidebar ul li a.active { background: var(--secondary-color); }
.sidebar ul li a i { margin-right:10px; font-size:1.2rem; width:20px; text-align:center; }

/* Main Content */
.main-content { margin-left:250px; padding:2rem; min-height:100vh; transition: margin-left 0.3s; }

/* Page Header */
.page-header { background:white; padding:25px 30px; border-radius:15px; box-shadow: var(--card-shadow); margin-bottom:30px; display:flex; justify-content:space-between; align-items:center; }
.page-title { font-size:2rem; font-weight:bold; color: var(--text-dark); margin:0; }
.page-subtitle { color: var(--text-light); margin:5px 0 0 0; }
.logout-btn { background: var(--danger-color); color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:all 0.3s; }
.logout-btn:hover { background:#c82333; }

/* Stats Cards */
.stats-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:25px; margin-bottom:30px; }
.stat-card { background:white; border-radius:15px; padding:25px; box-shadow: var(--card-shadow); text-align:center; transition:all 0.3s; }
.stat-card:hover { transform:translateY(-5px); box-shadow:0 8px 25px rgba(0,0,0,0.15); }
.stat-number { font-size:2rem; font-weight:bold; color: var(--primary-color); margin-bottom:10px; }
.stat-label { font-size:1rem; color: var(--text-light); }

/* Admin Actions */
.admin-actions { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:20px; margin-bottom:30px; }
.admin-actions a { display:block; text-align:center; padding:20px; border-radius:12px; font-weight:600; text-decoration:none; color:white; transition:all 0.3s; }
.btn-courses { background: var(--primary-color); } .btn-courses:hover { background: var(--secondary-color); }
.btn-instructors { background: #28a745; } .btn-instructors:hover { background: #218838; }
.btn-students { background: var(--warning-color); color: var(--text-dark); } .btn-students:hover { background: #e0a800; }
.btn-settings { background: #17a2b8; } .btn-settings:hover { background: #138496; }

@media(max-width:768px){
    .sidebar { width:100%; height:auto; position:relative; }
    .main-content { margin-left:0; padding:15px; }
    .stats-grid { grid-template-columns:1fr; }
    .admin-actions { grid-template-columns:1fr; }
    .page-header { flex-direction:column; gap:15px; text-align:center; }
}
</style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"><i class="bi bi-mortarboard"></i> SkillPro</div>
        <ul>
            <li><a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
            <?php if ($role === 'admin'): ?>
                <li><a href="admin/manage_courses.php"><i class="bi bi-book"></i>Courses</a></li>
                <li><a href="admin/manage_instructors.php"><i class="bi bi-person-badge"></i>Instructors</a></li>
                <li><a href="admin/manage_students.php"><i class="bi bi-people"></i>Students</a></li>
                <li><a href="admin/site_settings.php"><i class="bi bi-gear"></i>Settings</a></li>
            <?php elseif ($role === 'instructor'): ?>
                <li><a href="instructor/profile.php"><i class="bi bi-person-badge"></i>Profile</a></li>
                <li><a href="instructor/assigned_batches.php"><i class="bi bi-journal-bookmark"></i>Assigned Courses</a></li>
                <li><a href="instructor/upload_materials.php"><i class="bi bi-upload"></i>Upload Materials</a></li>
                <li><a href="instructor/student_list.php"><i class="bi bi-clipboard-data"></i>Student List</a></li>
            <?php elseif ($role === 'student'): ?>
                <li><a href="student/profile.php"><i class="bi bi-person"></i>Profile</a></li>
                <li><a href="student/courses.php"><i class="bi bi-book"></i>My Courses</a></li>
                <li><a href="student/assignments.php"><i class="bi bi-clipboard-check"></i>Assignments</a></li>
                <li><a href="student/exams.php"><i class="bi bi-file-text"></i>Exams</a></li>
                
                <li><a href="student/results.php"><i class="bi bi-graph-up"></i>Results</a></li>
            <?php endif; ?>
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <?php if ($role === 'admin'): ?>
                    <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h1>
                    <p class="page-subtitle">Manage courses, instructors, students, and site settings</p>
                <?php elseif ($role === 'instructor'): ?>
                    <h1 class="page-title">Welcome, Instructor <?php echo $username; ?> 👨‍🏫</h1>
                    <p class="page-subtitle">Manage your courses and evaluate student performance</p>
                <?php elseif ($role === 'student'): ?>
                    <h1 class="page-title">Hello, <?php echo $username . ($age ? " ($age)" : ""); ?>! 👋</h1>
                    <p class="page-subtitle">Welcome to your SkillPro Institute dashboard</p>
                <?php endif; ?>
            </div>
            <a href="logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <?php if ($role === 'admin'): ?>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['total_courses']; ?></div><div class="stat-label">Total Courses</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['instructors']; ?></div><div class="stat-label">Instructors</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['students']; ?></div><div class="stat-label">Students</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['pending_approvals']; ?></div><div class="stat-label">Pending Approvals</div></div>
            <?php elseif ($role === 'instructor'): ?>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['courses_taught']; ?></div><div class="stat-label">Courses Taught</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['total_students']; ?></div><div class="stat-label">Students</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['assignments']; ?></div><div class="stat-label">Assignments Given</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['exams']; ?></div><div class="stat-label">Exams Conducted</div></div>
            <?php elseif ($role === 'student'): ?>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['enrolled_courses']; ?></div><div class="stat-label">Enrolled Courses</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['completed']; ?></div><div class="stat-label">Completed</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['average_score']; ?>%</div><div class="stat-label">Average Score</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['assignments']; ?></div><div class="stat-label">Assignments</div></div>
                <div class="stat-card"><div class="stat-number"><?php echo $stats['exams']; ?></div><div class="stat-label">Exams</div></div>
            <?php endif; ?>
        </div>

        <!-- Admin Action Buttons -->
        <?php if ($role === 'admin'): ?>
            <div class="admin-actions mb-4">
                <a href="admin/manage_courses.php" class="btn-courses">Manage Courses</a>
                <a href="admin/manage_instructors.php" class="btn-instructors">Manage Instructors</a>
                <a href="admin/manage_students.php" class="btn-students">Manage Students</a>
                <a href="admin/site_settings.php" class="btn-settings">Site Settings</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
