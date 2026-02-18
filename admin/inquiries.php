<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$page_title = "View Inquiries";
include '../includes/header.php';
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Fetch inquiries
$stmt = $db->prepare("SELECT i.*, c.title AS course FROM inquiries i 
                      LEFT JOIN courses c ON i.course_id = c.id
                      ORDER BY i.id DESC");
$stmt->execute();
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2>Student Inquiries</h2>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Email</th>
        <th>Course</th>
        <th>Message</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($inquiries as $inq): ?>
        <tr>
          <td><?php echo $inq['id']; ?></td>
          <td><?php echo $inq['name']; ?></td>
          <td><?php echo $inq['email']; ?></td>
          <td><?php echo $inq['course'] ?? "General"; ?></td>
          <td><?php echo $inq['message']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
