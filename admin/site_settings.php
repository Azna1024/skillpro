<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$page_title = "Site Settings";

require_once '../config/database.php';
require_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?> - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --background-color: #f5f7fa;
    --accent-color: #28a745;
    --danger-color: #dc3545;
    --text-dark: #2c3e50;
    --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

body { font-family: "Segoe UI", Arial, sans-serif; margin:0; background: var(--background-color); }

/* Sidebar */
.sidebar {
    height: 100vh;
    width: 220px;
    position: fixed;
    top: 0; left: 0;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    flex-direction: column;
    z-index: 1000;
}
.sidebar .logo {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.sidebar ul { list-style: none; padding: 0; margin: 0; flex:1; }
.sidebar ul li a {
    display:flex; align-items:center; padding:1rem 1.2rem;
    color:white; text-decoration:none; font-weight:500;
    transition: all 0.3s;
}
.sidebar ul li a:hover, .sidebar ul li a.active { background: var(--secondary-color); }
.sidebar ul li a i { margin-right:10px; font-size:1.2rem; width:20px; text-align:center; }

/* Main Content */
.main-content { margin-left:220px; padding:2rem; min-height:100vh; transition: margin-left 0.3s; }

/* Page Header */
.page-header {
    background:white; padding:25px 30px; border-radius:15px; box-shadow: var(--card-shadow);
    margin-bottom:30px; display:flex; justify-content:space-between; align-items:center;
}
.page-title { font-size:2rem; font-weight:bold; color: var(--text-dark); margin:0; }

/* Settings Card */
.settings-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(300px,1fr));
    gap:25px;
}
.settings-card {
    background:white; border-radius:15px; padding:25px;
    box-shadow: var(--card-shadow); transition: all 0.3s;
}
.settings-card:hover { transform: translateY(-5px); box-shadow:0 8px 25px rgba(0,0,0,0.15); }
.settings-card h3 { font-size:1.4rem; font-weight:bold; margin-bottom:15px; color:var(--text-dark); }
.settings-card p { color:#555; line-height:1.6; }

.settings-actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:20px; }
.settings-actions a {
    flex:1; text-align:center; padding:10px 20px; border-radius:8px; font-weight:600; text-decoration:none; transition: all 0.3s;
}
.btn-edit { background: var(--primary-color); color:white; }
.btn-edit:hover { background: var(--secondary-color); color:white; }

@media(max-width:768px){
    .sidebar { width:100%; height:auto; position:relative; }
    .main-content { margin-left:0; padding:15px; }
    .settings-grid { grid-template-columns:1fr; }
}
</style>
</head>
<body>

<div class="sidebar">
    <div class="logo">SkillPro</div>
    <ul>
        <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="manage_courses.php"><i class="bi bi-book"></i> Manage Courses</a></li>
        <li><a href="manage_instructors.php"><i class="bi bi-people"></i> Manage Instructors</a></li>
        <li><a href="manage_students.php"><i class="bi bi-person-lines-fill"></i> Manage Students</a></li>
        <li><a href="site_settings.php" class="active"><i class="bi bi-gear"></i> Site Settings</a></li>
        <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title"><i class="bi bi-gear me-2"></i>Site Settings</h1>
    </div>

    <div class="settings-grid">
        <div class="settings-card">
            <h3>Site Name & Logo</h3>
            <p>Configure your website's name, logo, and favicon here. Make sure the branding matches your institute's style.</p>
            <div class="settings-actions">
                <a href="edit_site_name.php" class="btn-edit"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            </div>
        </div>

        <div class="settings-card">
            <h3>Contact Information</h3>
            <p>Update your institute's contact info like email, phone number, address, and social media links.</p>
            <div class="settings-actions">
                <a href="edit_contact_info.php" class="btn-edit"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            </div>
        </div>

        <div class="settings-card">
            <h3>Website Appearance</h3>
            <p>Adjust theme colors, fonts, homepage layout, and other UI settings to maintain a consistent look & feel.</p>
            <div class="settings-actions">
                <a href="edit_appearance.php" class="btn-edit"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            </div>
        </div>

        <div class="settings-card">
            <h3>Other Settings</h3>
            <p>Configure miscellaneous settings such as notifications, terms & conditions, privacy policy, and email templates.</p>
            <div class="settings-actions">
                <a href="edit_misc.php" class="btn-edit"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
