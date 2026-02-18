<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: ../login.php");
    exit;
}

$instructor_id = $_SESSION['user_id'];
$db = (new Database())->getConnection();

// Fetch the logged-in instructor info
$stmt = $db->prepare("SELECT * FROM users WHERE id = ? AND role = 'instructor'");
$stmt->execute([$instructor_id]);
$instructor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$instructor) {
    echo "Instructor not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --primary-color: #28a745;
    --secondary-color: #218838;
    --background-color: #f5f7fa;
    --danger-color: #dc3545;
    --text-dark: #2c3e50;
    --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
body { margin:0; font-family:"Segoe UI", Arial, sans-serif; background: var(--background-color); }
.sidebar { width:250px; position:fixed; top:0; left:0; height:100vh; background: var(--primary-color); color:#fff; display:flex; flex-direction:column; }
.sidebar .logo { font-size:1.5rem; font-weight:bold; text-align:center; padding:1.5rem 0; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar ul { list-style:none; padding:0; margin:0; flex:1; }
.sidebar ul li a { display:flex; align-items:center; padding:1rem 1.2rem; color:white; text-decoration:none; font-weight:500; transition:all 0.3s; }
.sidebar ul li a:hover, .sidebar ul li a.active { background: var(--secondary-color); }
.sidebar ul li a i { margin-right:10px; font-size:1.2rem; width:20px; text-align:center; }
.main-content { margin-left:250px; padding:2rem; min-height:100vh; }
.page-header { background:white; padding:25px 30px; border-radius:15px; box-shadow: var(--card-shadow); margin-bottom:30px; display:flex; justify-content:space-between; align-items:center; }
.page-title { font-size:2rem; font-weight:bold; color: var(--text-dark); margin:0; }
.card { background:white; border-radius:15px; padding:25px; box-shadow: var(--card-shadow); margin-bottom:30px; }
.logout-btn { background: var(--danger-color); color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:all 0.3s; }
.logout-btn:hover { background:#c82333; }
</style>
</head>
<body>

<div class="sidebar">
    <div class="logo"><i class="bi bi-mortarboard"></i> SkillPro</div>
    <ul>
        <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="profile.php" class="active"><i class="bi bi-person"></i> Profile</a></li>
        <li><a href="assigned_batches.php"><i class="bi bi-journal-bookmark"></i> Assigned Courses</a></li>
        <li><a href="upload_materials.php"><i class="bi bi-upload"></i> Upload Materials</a></li>
        <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <a href="../logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="card">
        <h4>👤 Instructor Details</h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($instructor['username']); ?></p>
        
        <p><strong>Email:</strong> <?= htmlspecialchars($instructor['email']); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($instructor['username']); ?></p>
        <p><strong>Joined On:</strong> <?= date('M d, Y', strtotime($instructor['created_at'] ?? '')); ?></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
