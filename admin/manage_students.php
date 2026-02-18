<?php
// -------------------------
// Start session safely
// -------------------------
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// -------------------------
// Database class
// -------------------------
class Database {
    private $host = "localhost";
    private $db_name = "skillpro_dp"; // change to your DB name
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("Database connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}

// -------------------------
// Database connection
// -------------------------
$database = new Database();
$db = $database->getConnection();

$page_title = "Manage Students";

// Fetch students
$stmt = $db->query("SELECT * FROM users WHERE role='student' ORDER BY id DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

/* Students Grid */
.students-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(320px,1fr));
    gap:25px;
}
.student-card {
    background:white; border-radius:15px; padding:25px;
    box-shadow: var(--card-shadow); transition: all 0.3s; border-left:5px solid var(--primary-color);
}
.student-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.student-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; }
.student-name { font-size:1.4rem; font-weight:bold; color: var(--text-dark); margin:0; flex:1; }
.student-email { color: var(--primary-color); font-weight:600; margin-bottom:10px; }
.student-actions { display:flex; gap:10px; margin-top:20px; flex-wrap:wrap; }
.student-actions a { flex:1; text-align:center; padding:10px 20px; border-radius:8px; font-weight:600; text-decoration:none; transition:all 0.3s; }
.btn-edit { background: var(--primary-color); color:white; }
.btn-edit:hover { background: var(--secondary-color); color:white; }
.btn-delete { background: var(--danger-color); color:white; }
.btn-delete:hover { background:#c82333; color:white; }
.btn-add { background: var(--accent-color); color:white; }
.btn-add:hover { background:#218838; }

@media(max-width:768px){
    .sidebar { width:100%; height:auto; position:relative; }
    .main-content { margin-left:0; padding:15px; }
    .students-grid { grid-template-columns:1fr; }
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
        <li><a href="manage_students.php" class="active"><i class="bi bi-person-lines-fill"></i> Manage Students</a></li>
        <li><a href="site_settings.php"><i class="bi bi-gear"></i> Settings</a></li>
        <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title"><i class="bi bi-person-lines-fill me-2"></i>Manage Students</h1>
        <a href="add_student.php" class="btn btn-add"><i class="bi bi-plus-circle me-1"></i> Add New Student</a>
    </div>

    <div class="students-grid">
        <?php if($students): foreach($students as $stu): ?>
        <div class="student-card">
            <div class="student-header">
                <h3 class="student-name"><?php echo htmlspecialchars($stu['username']); ?></h3>
            </div>
            <div class="student-email">
                <i class="bi bi-envelope me-1"></i> <?php echo htmlspecialchars($stu['email']); ?>
            </div>
            <div class="student-actions">
                <a href="edit_student.php?id=<?php echo $stu['id']; ?>" class="btn-edit"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                <a href="delete_student.php?id=<?php echo $stu['id']; ?>" class="btn-delete"><i class="bi bi-trash me-1"></i> Delete</a>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div class="alert alert-warning">No students found.</div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
