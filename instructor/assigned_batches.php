<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: ../login.php");
    exit;
}

require_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();

$instructor_id = $_SESSION['user_id'];

// Fetch assigned batches
$stmt = $db->prepare("SELECT b.*, c.title AS course_name 
                      FROM batches b 
                      JOIN courses c ON b.course_id = c.id 
                      WHERE b.instructor_id = ?");
$stmt->execute([$instructor_id]);
$batches = $stmt->fetchAll(PDO::FETCH_ASSOC);
$page_title = "My Assigned Batches";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
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

body { font-family: "Segoe UI", Arial, sans-serif; background: var(--background-color); margin:0; }

/* Sidebar */
.sidebar {
    width:220px; position:fixed; top:0; left:0; height:100vh;
    background: var(--primary-color); color:#fff; display:flex; flex-direction:column; z-index:1000;
}
.sidebar .logo { text-align:center; font-size:1.5rem; font-weight:bold; padding:1.5rem 0; border-bottom:1px solid rgba(255,255,255,0.2); }
.sidebar ul { list-style:none; padding:0; margin:0; flex:1; }
.sidebar ul li a { display:flex; align-items:center; padding:1rem; color:#fff; text-decoration:none; font-weight:500; transition:0.3s; }
.sidebar ul li a:hover, .sidebar ul li a.active { background: var(--secondary-color); }
.sidebar ul li a i { margin-right:10px; font-size:1.2rem; width:20px; text-align:center; }

/* Main Content */
.main-content { margin-left:220px; padding:2rem; min-height:100vh; }

/* Page Header */
.page-header { background:#fff; padding:25px 30px; border-radius:15px; box-shadow: var(--card-shadow); margin-bottom:30px; display:flex; justify-content:space-between; align-items:center; }
.page-title { font-size:2rem; font-weight:bold; color: var(--text-dark); margin:0; }
.logout-btn { background: var(--danger-color); color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:all 0.3s; }
.logout-btn:hover { background:#c82333; }

/* Batch Cards */
.batch-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:25px; }
.batch-card { background:#fff; border-radius:15px; padding:20px; box-shadow: var(--card-shadow); transition:all 0.3s; }
.batch-card:hover { transform:translateY(-5px); box-shadow:0 8px 25px rgba(0,0,0,0.15); }
.batch-card h5 { font-weight:bold; color: var(--primary-color); margin-bottom:10px; }
.batch-card p { margin:0.2rem 0; }

@media(max-width:768px){
    .sidebar { width:100%; height:auto; position:relative; }
    .main-content { margin-left:0; padding:15px; }
    .batch-grid { grid-template-columns:1fr; }
    .page-header { flex-direction:column; gap:15px; text-align:center; }
}
</style>
</head>
<body>

<div class="sidebar">
    <div class="logo"><i class="bi bi-mortarboard"></i> SkillPro</div>
    <ul>
        <li><a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
        <li><a href="upload_materials.php"><i class="bi bi-upload"></i> Materials</a></li>
        <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title"><i class="bi bi-journal-bookmark me-2"></i>My Assigned Batches</h1>
        <a href="../logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <?php if ($batches): ?>
        <div class="batch-grid">
            <?php foreach ($batches as $batch): ?>
                <div class="batch-card">
                    <h5><?= htmlspecialchars($batch['batch_name']); ?></h5>
                    <p><strong>Course:</strong> <?= htmlspecialchars($batch['course_name']); ?></p>
                    <p><strong>Start Date:</strong> <?= htmlspecialchars($batch['start_date']); ?></p>
                    <p><strong>End Date:</strong> <?= htmlspecialchars($batch['end_date']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No batches assigned yet.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
