<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$page_title = "Manage Courses";
include '../includes/header.php';
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

function showAlert($message, $type="info") {
    return "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
                {$message}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

$message = "";

// Delete course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM courses WHERE id = ?");
    if ($stmt->execute([$id])) {
        $message = showAlert("Course deleted!", "danger");
    }
}

// Fetch courses
$stmt = $db->prepare("SELECT c.*, u.username AS instructor FROM courses c 
                      LEFT JOIN users u ON c.instructor_id = u.id");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2>Manage Courses</h2>
  <?php echo $message; ?>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Duration (weeks)</th>
        <th>Instructor</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($courses as $course): ?>
        <tr>
          <td><?php echo $course['id']; ?></td>
          <td><?php echo $course['title']; ?></td>
          <td><?php echo $course['duration_weeks'] ?? '0'; ?></td>
          <td><?php echo $course['instructor'] ?? 'TBA'; ?></td>
          <td>
            <a href="?delete=<?php echo $course['id']; ?>" 
               onclick="return confirm('Delete this course?')" 
               class="btn btn-sm btn-danger">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
