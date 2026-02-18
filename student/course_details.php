<?php
// Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/functions.php';
requireLogin();

$course_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$course = getCourseById($course_id);

if (!$course) {
    die(showAlert("Course not found!", "danger"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($course['title']) ?> - SkillPro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 1rem; }
    .btn-primary { background: linear-gradient(90deg, #4e54c8, #8f94fb); border: none; }
    .btn-primary:hover { background: linear-gradient(90deg, #8f94fb, #4e54c8); }
  </style>
</head>
<body>

<div class="container my-5">
  <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Courses</a>
  
  <div class="card shadow-lg p-4">
    <h2 class="card-title mb-3"><?= htmlspecialchars($course['title']) ?></h2>
    <p class="card-text"><?= nl2br(htmlspecialchars($course['description'])) ?></p>

    <ul class="list-group list-group-flush my-3">
      <li class="list-group-item"><strong>Category:</strong> <?= htmlspecialchars($course['category_name'] ?? 'N/A') ?></li>
      <li class="list-group-item"><strong>Branch:</strong> <?= htmlspecialchars($course['branch_name'] ?? 'N/A') ?></li>
      <li class="list-group-item"><strong>Mode:</strong> <?= htmlspecialchars($course['mode']) ?></li>
      <li class="list-group-item"><strong>Fees:</strong> Rs. <?= number_format($course['fees'], 2) ?></li>
      <li class="list-group-item"><strong>Duration:</strong> <?= (int)$course['duration_months'] ?> months</li>
      <li class="list-group-item"><strong>Instructor:</strong> <?= htmlspecialchars($course['instructor_name'] ?? 'TBA') ?></li>
      <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($course['instructor_email'] ?? '-') ?></li>
      <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($course['instructor_phone'] ?? '-') ?></li>
      <li class="list-group-item"><strong>Expertise:</strong> <?= htmlspecialchars($course['instructor_expertise'] ?? '-') ?></li>
    </ul>

    <!-- Enroll Now Button -->
    <a href="inquiry.php?course_id=<?= $course['id'] ?>" class="btn btn-primary btn-lg mt-3">Enroll Now</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
