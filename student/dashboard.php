<?php
session_start();

// Redirect if not a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Fetch username and age from session
$username = htmlspecialchars($_SESSION['username']);
$age = isset($_SESSION['age']) ? (int)$_SESSION['age'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SkillPro Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ===== Root & Colors ===== */
        :root {
            --primary-color: #1976d2;
            --secondary-color: #f5f7fa;
            --accent-color: #28a745;
            --danger-color: #dc3545;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--secondary-color);
            margin: 0;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--primary-color);
            color: white;
            position: fixed;
            padding-top: 20px;
            transition: all 0.3s;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 250px;
            padding: 25px;
        }

        .welcome {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logout-btn {
            background: var(--danger-color);
            color: white;
            padding: 8px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        /* ===== Stats Cards ===== */
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1 1 200px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--text-light);
            margin-top: 5px;
        }

        /* ===== Responsive ===== */
        @media(max-width:768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .stats-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4><i class="bi bi-mortarboard"></i> SkillPro</h4>
    <a href="profile.php"><i class="bi bi-person"></i> Profile</a>
    <a href="courses.php"><i class="bi bi-book"></i> My Courses</a>
    <a href="assignments.php"><i class="bi bi-clipboard-check"></i> Assignments</a>
    <a href="exams.php"><i class="bi bi-file-text"></i> Exams</a>
    <a href="results.php"><i class="bi bi-graph-up"></i> Results</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    

</div>

<!-- Main Content -->
<div class="main-content">
    <div class="welcome">
        <h2>Hello, <?php echo $username . ($age ? " ({$age})" : ""); ?>! 👋</h2>
        
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">5</div>
            <div class="stat-label">Enrolled Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">3</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">85%</div>
            <div class="stat-label">Average Score</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">4</div>
            <div class="stat-label">Assignments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">2</div>
            <div class="stat-label">Exams</div>
        </div>
    </div>

    <p>Welcome to your SkillPro Institute dashboard! Use the sidebar to navigate through courses, assignments, exams, results, and more.</p>
</div>

</body>
</html>
