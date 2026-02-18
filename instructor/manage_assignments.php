<?php
session_start();
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor'){ header("Location: login.php"); exit; }
$instructor_id = $_SESSION['user_id'];
$db = (new Database())->getConnection();
$stmt = $db->prepare("SELECT a.*, c.title as course_title FROM assignments a JOIN courses c ON a.course_id=c.id WHERE c.instructor_id=?");
$stmt->execute([$instructor_id]);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Assignments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="dashboard-style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="main-content">
<h2>Assignments</h2>
<a href="create_assignment.php" class="btn btn-success mb-3">Create Assignment</a>
<table class="table table-bordered">
<tr><th>Title</th><th>Course</th><th>Due Date</th><th>Actions</th></tr>
<?php foreach($assignments as $a): ?>
<tr>
<td><?php echo htmlspecialchars($a['title']); ?></td>
<td><?php echo htmlspecialchars($a['course_title']); ?></td>
<td><?php echo htmlspecialchars($a['due_date']); ?></td>
<td>
<a href="edit_assignment.php?id=<?php echo $a['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
<a href="view_submissions.php?id=<?php echo $a['id']; ?>" class="btn btn-sm btn-primary">View</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
