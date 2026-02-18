<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor'){
    header("Location: login.php"); exit;
}
$instructor_id = $_SESSION['user_id'];
$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT * FROM users WHERE instructor_id = ?");
$stmt->execute([$instructor_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Courses</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="dashboard-style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="main-content">
<h2>My Courses</h2>
<a href="create_course.php" class="btn btn-success mb-3">Create New Course</a>
<div class="row">
<?php foreach($courses as $course): ?>
<div class="col-md-4">
<div class="card mb-3">
<div class="card-body">
<h5><?php echo htmlspecialchars($course['title']); ?></h5>
<p><?php echo htmlspecialchars($course['description']); ?></p>
<a href="course_details.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-sm">View</a>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</body>
</html>
