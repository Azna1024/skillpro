<?php
session_start();
require_once '../config/database.php';

// Redirect if not logged in or not instructor
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor'){
    header("Location: ../login.php");
    exit;
}

// Get instructor ID
$instructor_id = $_SESSION['user_id'];

// Database connection
$db = (new Database())->getConnection();

// Fetch exams for this instructor
$stmt = $db->prepare("
    SELECT e.*, c.title AS course_title 
    FROM exams e
    JOIN courses c ON e.course_id = c.id
    WHERE c.instructor_id = ?
    ORDER BY e.exam_date DESC
");
$stmt->execute([$instructor_id]);
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instructor Exams</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="dashboard-style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2>Exams</h2>
    <a href="create_exam.php" class="btn btn-success mb-3">Create Exam</a>
    
    <?php if(count($exams) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Course</th>
                <th>Date</th>
                <th>Duration (mins)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($exams as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['title']); ?></td>
                <td><?= htmlspecialchars($e['course_title']); ?></td>
                <td><?= htmlspecialchars(date('M d, Y', strtotime($e['exam_date']))); ?></td>
                <td><?= htmlspecialchars($e['duration']); ?></td>
                <td>
                    <a href="edit_exam.php?id=<?= $e['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <a href="grade_exam.php?id=<?= $e['id']; ?>" class="btn btn-sm btn-primary">Grade</a>
                    <a href="delete_exam.php?id=<?= $e['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="text-muted">No exams found for your courses.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
