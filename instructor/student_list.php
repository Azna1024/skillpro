<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';
$db = (new Database())->getConnection();

$user_id = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username'] ?? 'Instructor');

// Fetch students for instructor’s courses
$sql = "SELECT s.id, s.full_name, s.email, c.title AS course_name
        FROM students s
        JOIN enrollments e ON s.id = e.student_id
        JOIN courses c ON e.course_id = c.id
        WHERE c.instructor_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$user_id]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student List - Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --primary-color: #28a745;
    --secondary-color: #218838;
    --background-color: #f5f7fa;
    --danger-color: #dc3545;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
body { font-family:"Segoe UI", Arial, sans-serif; background: var(--background-color); margin:0; }

/* Sidebar */
.sidebar { height:100vh; width:250px; position:fixed; top:0; left:0; background:var(--primary-color); color:#fff; display:flex; flex-direction:column; }
.sidebar .logo { font-size:1.5rem; font-weight:bold; text-align:center; padding:1.5rem 0; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar ul { list-style:none; padding:0; margin:0; flex:1; }
.sidebar ul li a { display:flex; align-items:center; padding:1rem 1.2rem; color:white; text-decoration:none; font-weight:500; transition:all 0.3s; }
.sidebar ul li a:hover, .sidebar ul li a.active { background: var(--secondary-color); }
.sidebar ul li a i { margin-right:10px; font-size:1.2rem; width:20px; text-align:center; }

/* Main Content */
.main-content { margin-left:250px; padding:2rem; min-height:100vh; transition: margin-left 0.3s; }
.page-header { background:white; padding:25px 30px; border-radius:15px; box-shadow: var(--card-shadow); margin-bottom:30px; display:flex; justify-content:space-between; align-items:center; }
.page-title { font-size:2rem; font-weight:bold; color: var(--text-dark); margin:0; }
.page-subtitle { color: var(--text-light); margin:5px 0 0 0; }
.logout-btn { background: var(--danger-color); color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:all 0.3s; }
.logout-btn:hover { background:#c82333; }

/* Cards */
.card { background:white; border-radius:15px; padding:25px; box-shadow: var(--card-shadow); margin-bottom:30px; }
.card h4 { margin-bottom:20px; }

/* Table */
.table thead th { background: var(--primary-color); color:white; }
.table tbody tr:hover { background:#e8f5e9; }

@media(max-width:768px){
    .sidebar { width:100%; height:auto; position:relative; }
    .main-content { margin-left:0; padding:15px; }
    .page-header { flex-direction:column; gap:15px; text-align:center; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo"><i class="bi bi-mortarboard"></i> SkillPro</div>
    <ul>
        <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
        <li><a href="assigned_batches.php"><i class="bi bi-journal-bookmark"></i> Assigned Courses</a></li>
        <li><a href="upload_materials.php"><i class="bi bi-upload"></i> Upload Materials</a></li>
        <li><a href="student_list.php" class="active"><i class="bi bi-clipboard-data"></i> Student List</a></li>
        <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">👨‍🎓 Student List</h1>
            <p class="page-subtitle">Students enrolled in your courses</p>
        </div>
        <a href="../logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <div class="card">
        <?php if (count($students) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $i => $student): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['course_name']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-muted">No students enrolled yet.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-secondary mt-3">⬅ Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
